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

//_end($model);

$this->title = 'Файлы материала ' . $model->si_name_info;
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
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'si_id',
            'si_text:ntext',
        ],
    ])
    ?>
    <?php Pjax::end(); ?></div>
<?php

?>
