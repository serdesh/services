<?php

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Ftpaccounts;

$list_login = ArrayHelper::map(Ftpaccounts::find()->orderBy(['ftp_login' => 'ASC'])->all(), 'ftp_id', 'ftp_login');

Modal::begin([
    'header' => '<h2>Отправка файла по FTP</h2>',
    'toggleButton' => [
        'label' => 'Отправить по фтп',
        'class' => 'btn btn-info'
    ],
    'footer' => 'По всем вопросам обращаться к Дешковичу С.С. тел: 5-06-25'
])
?>
<div class="ftp-form modal-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'file')->textInput(['value' => $file]) ?>
    <?= $form->field($model, 'ftp_id')->dropDownList($list_login) ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end(); ?>