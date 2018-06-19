<?php

namespace app\controllers;

use Yii;
use app\models\Siteinfo;
use app\models\SiteinfoSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\Mapinfo;
use app\models\User;
use ZipArchive;
use \app\components\ImgHelper;
use yii\filters\AccessControl;


/**
 * SiteinfoController implements the CRUD actions for Siteinfo model.
 */
class SiteinfoController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Siteinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SiteinfoSearch();
        if (User::isAdmin()) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Siteinfo::find()->where(['=', 'si_user_id', app()->user->id]),
            ]);
            $dataProvider->sort->defaultOrder = ['si_data' => SORT_DESC];
        }


        if (Yii::$app->user->isGuest) {
            echo '<script> alert("Для работы с сервисами авторизируйтесь или пройдите процедуру регистрации!")</script>';
            return $this->render('/site/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii2mod\ftp\FtpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('view', [
                'model' => $model,
                'result' => Siteinfo::sendFtp($model)

            ]);
        }

        return $this->render('view', [
            'model' => $model,

        ]);
    }

    /**
     * Creates a new Siteinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Siteinfo();
        $attribute = "";
        if ($model->load(Yii::$app->request->post())) {
            $model->Files = UploadedFile::getInstances($model, 'Files');
            if (!User::isAdmin()) {
                $model->si_division_id = app()->user->identity->division_id;
            }

            if (!$model->si_text && !$model->Files) {
                $model->addError($attribute, 'Необходимо заполнить поле "Текст информации" или прикрепить файлы.');
                return $this->render('create', [
                    'model' => $model,]);
            }

            $add_permission = Mapinfo::findOne(['mi_id' => $model->si_map_id])->mi_add_permission;
            $map_name = Mapinfo::findOne(['mi_id' => $model->si_map_id])->mi_name;
            if ($add_permission == 0) {
                $model->addError($attribute, 'В разделе "' . $map_name . '" размещение информации невозможно.');
                return $this->render('create', [
                    'model' => $model,]);
            }
        }
        $path_attach = 'uploads/siteinfo/' . Yii::$app->user->identity->division_id . '/' . date('d.m.Y') . '/' . date('His');
        $model->si_path_attach = $path_attach;

        if ($model->save()) {
            if ($model->Files && $model->validate()) {
                if (mkdir($path_attach, 0777, TRUE)) {
                    foreach ($model->Files as $file) {
                        $tmpFile = $file->tempName;
                        if (getimagesize($tmpFile)) {
                            //Еслии картинка - сжимаем
                            $path = $path_attach . '/' . time() . '.' . $file->extension;
                            ImgHelper::resizeImage($tmpFile, $path, 800);
                        } else {
                            //Если не картинка - обрезаем длинное название и сохраняем
                            $fileName = substr(app()->transliter->translate($file->baseName), 0, 70);
//                            $fileName = app()->transliter->translate($file->baseName);
//                            $fileName = time();
                            $path = $path_attach . '/' . $fileName . '.' . $file->extension;
                            $file->saveAs($path);
                        }
                    }
                }

            }
            //return $this->redirect(['view', 'id' => $model->si_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Siteinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            if ($model->si_end_public) {
                $model->si_end_public = Date('Y-m-d', strtotime($model->si_end_public)); //Преобразовываем дату для Датапикера
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Меняем значение статуса на '2' т.е. опубликовано
     * @var int $id Код информации
     * @return string
     * @throws NotFoundHttpException
     */
    Public function actionSetstatus($id)
    {
        $model = $this->findModel($id);
        $model->si_status = 2;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Siteinfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        //Проверяем права на удаление
        if (User::isAdmin() or Siteinfo::isAuthor($id)) { //Если админ или автор материала
            //Удаляем папку
            $dir = Siteinfo::findOne(['si_id' => $this->findModel($id)->si_id])->si_path_attach;
            if ($dir){
                Siteinfo::removeDirectory($dir);
            } else {
                app()->session->setFlash('eroor', 'Не верный путь.' . $dir);
            }
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            return \yii\web\HttpException('У вас нет доступа к операции удаления');
        }
    }

    /**
     * Finds the Siteinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Siteinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Siteinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая стрница не существует.');
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii2mod\ftp\FtpException
     */
    public function actionFiles($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            return $this->render('files', ['model' => $this->findModel($id), 'result' => $this->sendFtp($model)]);
            return $this->render('files', ['model' => $model, 'result' => Siteinfo::sendFtp($model)]);
        } else {
            $query = new Query();
            $provider = new ActiveDataProvider([
                'query' => $query->find('post'),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            return $this->render('files', ['model' => $model, 'dataProvider' => $provider]);
        }
    }

    public function actionZipdirectory($sourceDir, $destDir, $id)
    {
        $zip = new ZipArchive();
        //$filename = "D:/test/arhiv.zip";
        $filename = $destDir . '/' . microtime(true) . '.zip';
        if (!is_dir($destDir)) {
            mkdir($destDir);
        }

        if (!$zip->open($filename, ZIPARCHIVE::CREATE)) {
            exit("Не могу открыть " . $filename . '<br>' . $destDir);
        }

        if ($objs = glob($sourceDir . "/*")) {
            foreach ($objs as $obj) {
                if (is_file($obj)) {
                    $zip->addFile($obj, '/' . basename($obj));
                }
            }
        }
        //$zippedcount = $zip->numFiles;
        $zip->close();
        unset($zip);
        //return $this->render('files', ['model' => $this->findModel($id), 'zippedcount' => $zippedcount]);
        //\yii\helpers\VarDumper::dump(Yii::getAlias('@webroot/' . $filename));
        //Yii::$app->response->sendFile(Yii::getAlias('@webroot/' . $filename));
        Yii::$app->response->sendFile($filename, null, ['mimeType' => 'application/octet-stream']);
    }

    public function actionCopyfiles($sourceDir, $destDir, $id)
    {
        $count = 0;
        if (!file_exists($destDir)) {
            mkdir($destDir, 0777, TRUE);
        }

        if ($objs = glob($sourceDir . "/*")) {
            foreach ($objs as $obj) {
                if (is_file($obj)) {
                    copy($obj, $destDir . '/' . basename($obj));
                    $count += 1;
                }
            }
        }
        return $this->render('files', ['model' => $this->findModel($id), 'count' => $count]);
    }

}
