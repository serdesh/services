<?php

namespace app\controllers;

use Yii;
use app\models\Siteinfo;
use app\models\SiteinfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use app\models\Mapinfo;
use app\models\User;
use app\models\Ftpaccounts;
use ZipArchive;


/**
 * SiteinfoController implements the CRUD actions for Siteinfo model.
 */
class SiteinfoController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
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
    public function actionIndex() {
        $searchModel = new SiteinfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
     * Displays a single Siteinfo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Siteinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Siteinfo();
        $attribute = "";
        if ($model->load(Yii::$app->request->post())) {
            $model->Files = UploadedFile::getInstances($model, 'Files');
            $path_attach = 'uploads/siteinfo/' . Yii::$app->user->identity->division_id . '/' . date('d.m.Y') . '/' . date('His');
            if (mkdir($path_attach, 0777, TRUE)) {
                $model->si_path_attach = $path_attach;
            }

            if (!User::isAdmin()) {
                $model->si_division_id = Yii::$app->user->identity->division_id;
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

        if ($model->save()) {
            if ($model->Files && $model->validate()) {
                foreach ($model->Files as $file) {
                    //$path = $path_attach . '/' . $file->baseName . '.' . $file->extension;
                    //$path = $path_attach . '/' . iconv("UTF-8", "windows-1251",$file->baseName) . '.' . $file->extension;
                    //$path = $path_attach . '/' . Inflector::transliterate(mb_strtolower($file->baseName)) . '.' . $file->extension; //отображает корректно руские названия файлов
                    $path = $path_attach . '/' . Yii::$app->transliter->translate($file->baseName) . '.' . $file->extension;

                    $file->saveAs($path);
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
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->si_id]);
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
     */
    Public function actionSetstatus($id) {
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
     */
    public function actionDelete($id) {
        //Проверяем права на удаление 
        if (User::isAdmin() or Yii::$app->user->identity->id == Siteinfo::findOne(['si_id' => $id])->si_user_id) { //Еслиадмин или автор материала
            //Удаляем папку
            $dir = Siteinfo::findOne(['si_id' => $this->findModel($id)->si_id])->si_path_attach;
            $this->removeDirectory($dir);
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
    protected function findModel($id) {
        if (($model = Siteinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая стрница не существует.');
        }
    }

    protected function removeDirectory($dir) {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                is_dir($obj) ? removeDirectory($obj) : unlink($obj);
            }
        }
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    public function actionFiles($id) {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             return $this->render('files', ['model' => $this->findModel($id), 'result' => $this->sendFtp($model)]);
        } else {
            return $this->render('files', ['model' => $this->findModel($id)]);
        }
    }

    private function sendFtp($model) { //Отправка файла по FTP
        $ftp = new \yii2mod\ftp\FtpClient();
        if ($model->desiredname) {
            $fileName = $model->desiredname;
        } else {
                $fileName = $model->selectedfile;
        }
         
        $localPath = $model->si_path_attach . '/' . $model->selectedfile; //Путь к локальному файлу

        $query = Ftpaccounts::findOne(['ftp_id' => $model->ftp_id]);
        $ftpLogin = $query->ftp_login;
        $ftpPass = $query->ftp_pass;
        $host = $query->ftp_site;

        $ftp->connect($host);
        
        if ($ftp->login($ftpLogin, $ftpPass)) {
            $count = $ftp->count();
            $ftp->put($fileName, $localPath, FTP_BINARY);
            if ($count !=  $ftp->count()) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function actionZipdirectory($sourceDir, $destDir, $id) {
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
        $zippedcount = $zip->numFiles;
        $zip->close();
        unset($zip);
        //return $this->render('files', ['model' => $this->findModel($id), 'zippedcount' => $zippedcount]);
        //\yii\helpers\VarDumper::dump(Yii::getAlias('@webroot/' . $filename));
        //Yii::$app->response->sendFile(Yii::getAlias('@webroot/' . $filename));
        Yii::$app->response->sendFile($filename, null, ['mimeType' => 'application/octet-stream']);
    }

    public function actionCopyfiles($sourceDir, $destDir, $id) {
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
