<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <div class="row">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Пожалуйста, заполните следующие поля для входа:</p>
            </div>
            <div class="col-md-12">
                <div class="loginform">

                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'layout' => 'horizontal',
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                                ],
                    ]);
                    ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Логин'])->label('') ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label('') ?>
                    </div>
                    <?=
                    $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label('Запомнить меня')
                    ?>
                
            </div>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="row">
<!--            <div style="color:#999;margin:1em 0">
                Если вы забыли свой пароль вы можете <?php // echo Html::a('сбросить пароль', ['site/password-reset']) ?>.
            </div>-->
        </div>
    </div>


</div>
