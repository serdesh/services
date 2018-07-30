<?php

namespace app\controllers;

use app\components\ZipFiles;
use Yii;
use app\models\Vestnik;
use app\models\VestnikSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * VestnikController implements the CRUD actions for Vestnik model.
 */
class VestnikController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Vestnik models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VestnikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vestnik model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vestnik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Vestnik();
        $pathDestinationDirectory = 'uploads/documents/vestnik';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->vest_numberlitera) {
                $model->vest_fullnumber = $model->vest_number . '-' . $model->vest_numberlitera;
            } else {
                $model->vest_fullnumber = $model->vest_number;
            }

            $model->file = UploadedFile::getInstance($model, 'file');

            if (!is_dir($pathDestinationDirectory)) {
                mkdir($pathDestinationDirectory, 0777, TRUE);
            }
            $model->vest_pathfile = $pathDestinationDirectory . '/Vestnik' . $model->vest_fullnumber . '_' . date('Y', strtotime($model->vest_data)) . '.zip';
            if (!$model->file) {
                $model->addError('warning', 'Необходимо прикрепить файл с вестником.');
                return $this->render('create', [
                            'model' => $model,]);
            }
        }

        if ($model->save()) {
            if ($model->file && $model->validate()) {
                $path = $pathDestinationDirectory . '/Vestnik' . $model->vest_fullnumber . '_' . $model->vest_data . '.' . $model->file->extension; //отображает корректно руские названия файлов
                ZipFiles::zipFile($model->file, $model->vest_pathfile, Inflector::transliterate(mb_strtolower($model->file->baseName)) . '.' . $model->file->extension);
//                $model->file->saveAs($path);
            }
            return $this->redirect(['view', 'id' => $model->vest_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Vestnik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->vest_pathfile = Vestnik::setNewPath($model);//какая-то ебанина, переименовывает файл при втором заходе в редактирование
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->vest_id]);
            
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id) {

        $file = Vestnik::findOne(['vest_id' => $this->findModel($id)->vest_id])->vest_pathfile;
        if (file_exists($file)) {
            unlink($file);
        }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Vestnik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vestnik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Vestnik::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFiles($id) {
        $model = $this->findModel($id);
        return $this->render('files', ['model' => $model]);
    }
    
    

}
