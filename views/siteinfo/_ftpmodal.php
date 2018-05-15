<?php

/**
 * @var $model app\models\Siteinfo
 * @var array $list_login Список фтп логинов
 */

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Ftpaccounts;
use \app\models\Siteinfo;

$file = '';
$list_login = ArrayHelper::map(Ftpaccounts::find()->orderBy(['ftp_login' => 'ASC'])->all(), 'ftp_id', 'ftp_login');

$path_attach =  $model->si_path_attach;
$list_files = Siteinfo::getFilesInArray($path_attach);
?>

    <div class="ftp-form modal-body">
        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'selectedfile')->dropDownList($list_files) ?>
        <?php echo $form->field($model, 'desiredname')->textInput(['value' => $file]) ?>
        <?php echo $form->field($model, 'ftp_id')->dropDownList($list_login)->label('FTP логин') ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-block']) ?>
        <?php ActiveForm::end(); ?>
    </div>

