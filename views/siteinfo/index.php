<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\models\Mapinfo;
use app\models\Statusinfo;
//use yii\web\View;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel app\models\SiteinfoSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Информация для сайта';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid siteinfo-index">
    <div class="row">
        <div class="col-md-10 col-sm-12">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]);     ?>
        </div>
        <div class="col-md-2 col-sm-12">
            <h1>
                <?= Html::a('Добавить информацию', ['create'], ['class' => 'btn btn-block btn-success']) ?>
            </h1>
        </div>
    </div>

    <?php
    if (User::isUserAdmin(Yii::$app->user->identity->username)) {
        $buttons = '{view} {update} {delete}';
    } else {
        $buttons = '{view} {delete}';
    }
    ?>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'class' => 'index-table',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'si_id',
            //'si_data',
            [
                'attribute' => 'si_data',
                'value' => function ($data) {
                    return date('d.m.Yг. H:i', strtotime($data->si_data));
                },
            ],
            'si_name_info',
            [
                'attribute' => 'section',
                'label' => 'Раздел',
                'value' => function ($data) {
                    //yii\helpers\VarDumper::dump($data->section->mi_name);
                    return Mapinfo::getFullpathcategory($data->section->mi_id);
                }
            ],
            [
                'attribute' => 'employee',
                'label' => 'Пользователь',
                'format' => 'raw',
                'value' => function ($data) {
                    return User::getShortname($data->employee->fio);
                },
            ],
            [
                'attribute' => 'si_status',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->si_status == '1') {
                        //Ожидание публикации
                        $img = Html::a('', Url::toRoute(['/siteinfo/setstatus', 'id' => $data->si_id]), [
                            'class' => 'btn btn-warning glyphicon glyphicon-hourglass',
                            //'onclick' => 'change_permission(); false;',
                            'data-toggle' => 'tooltip',
                            'title' => 'Ожидает публикации',
                            'id' => 'btn-waitpublish-' . $data->si_id,
                        ]);
                    } elseif ($data->si_status == '2') {
                        //Опубликовано
                        $img = Html::button('', [
                            'class' => 'btn btn-success glyphicon glyphicon-ok',
                            //'onclick' => 'change_permission(); false;',
                            'data-toggle' => 'tooltip',
                            'title' => 'Опубликовано',
                            'id' => 'btn-published-' . $data->si_id,
                        ]);
                    } elseif ($data->si_status == '3') {
                        //Отказано
                        $img = Html::button('', [
                            'class' => 'btn btn-danger glyphicon glyphicon-remove',
                            //'onclick' => 'change_permission(); false;',
                            'data-toggle' => 'tooltip',
                            'title' => 'Отказано в публикации',
                            'id' => 'btn-dontpublish-' . $data->si_id,
                        ]);
                    } else {
                        $img = Statusinfo::findOne(['stat_id' => $data->si_status])->stat_name;
                    }
                    return $img;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        if (User::isUserAdmin(Yii::$app->user->identity->username) or (Yii::$app->user->identity->id == $model->si_user_id)) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    'update' => function ($model, $key, $index) {
                        return User::isUserAdmin(Yii::$app->user->identity->username);
                    }
                ]
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
<?php

?>
