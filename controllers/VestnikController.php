<?php

namespace app\controllers;

use Yii;
use app\models\Vestnik;
use app\models\VestnikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;

/**
 * VestnikController implements the CRUD actions for Vestnik model.
 */
class VestnikController extends Controller {

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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->vest_numberlitera) {
                $model->vest_fullnumber = $model->vest_number . '-' . $model->vest_numberlitera;
            } else {
                $model->vest_fullnumber = $model->vest_number;
            }

            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $path_dest_dir = 'uploads/documents/vestnik';
            if (!is_dir($path_dest_dir)) {
                mkdir($path_dest_dir, 0777, TRUE);
            }
            $model->vest_pathfile = $path_dest_dir . '/Vestnik' . $model->vest_fullnumber . '_' . date('Y', strtotime($model->vest_data)) . '.zip';

            if (!$model->file) {
                $model->addError($attribute, 'Необходимо прикрепить файл с вестником.');
                return $this->render('create', [
                            'model' => $model,]);
            }
        }
        // \yii\helpers\VarDumper::dump($model->file);

        if ($model->save()) {
            if ($model->file && $model->validate()) {
                $path = $path_dest_dir . '/Vestnik' . $model->vest_fullnumber . '_' . $model->vest_data . '.' . $model->file->extension; //отображает корректно руские названия файлов
                Vestnik::zipfile($model->file, $model->vest_pathfile, Inflector::transliterate(mb_strtolower($model->file->baseName)) . '.' . $model->file->extension);
//                \yii\helpers\VarDumper::dump($path);
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
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        //$model->load(Yii::$app->request->post());
        $model->vest_pathfile = Vestnik::set_newpath($model);//какая-то ебанина, переименовывает файл при втором заходе в редактирование
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->vest_id]);
            
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Vestnik model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
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
    
     public function actionFiles($id) {
        $model = $this->findModel($id);
        return $this->render('files', ['model' => $this->findModel($id)]);
    }
    
    

}
