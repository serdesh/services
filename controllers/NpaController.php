<?php

namespace app\controllers;

use Yii;
use app\models\Npa;
use app\models\NpaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use app\models\User;
use yii\web\ForbiddenHttpException;

/**
 * NpaController implements the CRUD actions for Npa model.
 */
class NpaController extends Controller {

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
     * Lists all Npa models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NpaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Npa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Npa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Npa();
        if ($model->load(Yii::$app->request->post())) {

            $model->npa_fullnumber = $this->get_npa_fullnumber($model);

            $model->file = UploadedFile::getInstance($model, 'file');

            $path_dest_dir = $this->set_path_dest_dir('uploads/documents/npa');

            $model->npa_path = $path_dest_dir . '/' . Npa::get_trans_typename($model) . Inflector::transliterate(mb_strtolower($model->npa_fullnumber)) . '_' . date('d.m.Y', strtotime($model->npa_date_adoption)) . '.zip';

            $model->npa_user_id = Yii::$app->user->identity->id;
        }

        if ($model->save()) {
            if (!$model->file) {
                $model->addError($attribute, 'Необходимо прикрепить файл с документом.');
                return $this->render('create', ['model' => $model]);
            }
            if ($model->file && $model->validate()) {
                //$path = $path_dest_dir . '/' . Npa::get_trans_typename($model) . Inflector::transliterate(mb_strtolower($model->npa_fullnumber)) . '_' . date('d.m.y', $model->npa_date_adoption) . '.' . $model->file->extension; //отображает корректно руские названия файлов
                Npa::zipfile($model->file, $model->npa_path, Inflector::transliterate(mb_strtolower($model->file->baseName)) . '.' . $model->file->extension);
            }
            return $this->redirect(['view', 'id' => $model->npa_id]);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Npa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            $old_file = $model->npa_path;
            
            $model->npa_fullnumber = $this->get_npa_fullnumber($model);

            $model->file = UploadedFile::getInstance($model, 'file');

            $path_dest_dir = $this->set_path_dest_dir('uploads/documents/npa');

            $model->npa_path = $path_dest_dir . '/' . Npa::get_trans_typename($model) . Inflector::transliterate(mb_strtolower($model->npa_fullnumber)) . '_' . date('d.m.Y', strtotime($model->npa_date_adoption)) . '.zip';

            $model->npa_user_id = Yii::$app->user->identity->id;
        }

        if ($model->save()) {
            if (!$model->file) {
                $model->addError($attribute, 'Необходимо прикрепить файл с документом.');
                return $this->render('create', ['model' => $model]);
            }
            if ($model->file && $model->validate()) {
                if (file_exists($old_file)){
                    unlink($old_file);
                }
                //$path = $path_dest_dir . '/' . Npa::get_trans_typename($model) . Inflector::transliterate(mb_strtolower($model->npa_fullnumber)) . '_' . date('d.m.y', $model->npa_date_adoption) . '.' . $model->file->extension; //отображает корректно руские названия файлов
                Npa::zipfile($model->file, $model->npa_path, Inflector::transliterate(mb_strtolower($model->file->baseName)) . '.' . $model->file->extension);
            }
            return $this->redirect(['view', 'id' => $model->npa_id]);
        } else {
            return $this->render('update', ['model' => $model]);
        }
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            
//            return $this->redirect(['view', 'id' => $model->npa_id]);
//        } else {
//            return $this->render('update', [
//                        'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Npa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        if (Npa::isAutor($this->findModel($id)) or User::isAdmin()) {

            $target_file = Npa::findOne(['npa_id' => $id])->npa_path;

            if ($this->findModel($id)->delete()) {
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            }
        } else {
            throw new ForbiddenHttpException('Удаление невозможно. Доступ запрещен');
        }
        return $this->redirect(['index']);
    }

    public function actionFiles($id) {
        $model = $this->findModel($id);
        return $this->render('files', ['model' => $this->findModel($id)]);
    }

    /**
     * Finds the Npa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Npa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Npa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

    public function get_npa_fullnumber($model) {
        if ($model->npa_literanumber) {
            return $model->npa_number . '-' . $model->npa_literanumber;
        } else {
            return $model->npa_number;
        }
    }

    public function set_path_dest_dir($path_dest_dir) {
        if (!$path_dest_dir) {
            mkdir($path_dest_dir, 0777, true);
        }
        return $path_dest_dir;
    }

}
