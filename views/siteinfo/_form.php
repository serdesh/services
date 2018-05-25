<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Mapinfo;
use app\models\User;
use app\models\Statusinfo;
use kartik\select2\Select2;
use app\models\Division;

$cur_user = '';
?>

<div class="siteinfo-form">
    <?php
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <?php echo $form->errorSummary($model); ?>
    <?php
    if (User::isUserAdmin(Yii::$app->user->identity->username)) {

        $stat_items = ArrayHelper::map(Statusinfo::find()->all(), 'stat_id', 'stat_name');
        echo '<div class="row"><div class="col-md-4">';
        echo $form->field($model, 'si_status')->dropDownList($stat_items);
        echo '</div><div class="col-md-4">';
        $list_user = ArrayHelper::map(User::find()->orderBy(['fio' => 'ASC'])->all(), 'id', 'fio');

        if ($model->si_user_id) {
            $cur_user = User::findOne(['id' => $model->si_user_id])->id;
        }


        if ($cur_user) {
            echo $form->field($model, 'si_user_id')->dropDownList($list_user, [
                'value' => $cur_user,
            ])->label('Пользователь');
        } else {
            echo $form->field($model, 'si_user_id')->widget(Select2::classname(), [
                'data' => $list_user,
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберика пользователя'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        }
        echo '</div><div class="col-md-4">';
        echo $form->field($model, 'si_division_id')->dropDownList(ArrayHelper::map(Division::find()->orderBy(['div_name' => 'ASC'])->all(), 'div_id', 'div_name'))->label('Подразделение');
        echo '</div></div>';
    } else {
        echo $form->field($model, 'si_user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label('');
        echo $form->field($model, 'si_division_id')->hiddenInput([
            'value' => Yii::$app->user->identity->division_id,
        ])->label('');
    }
    ?>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <?=
            $form->field($model, 'si_data')->Input('date', [
                'value' => date('Y-m-d'),
                'disabled' => true,
            ])
            ?>
        </div>
        <div class="col-md-9 col-sm-12">
            <?php
            $list = Mapinfo::getList();
            echo $form->field($model, 'si_map_id')->widget(Select2::classname(), [
                'data' => $list,
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите раздел'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Раздел');
            ?>
        </div>
    </div>
    <?= $form->field($model, 'si_name_info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'si_text')->textarea(['rows' => 6]) ?>

    <?=
    $form->field($model, 'si_end_public')->Input('date', [
        'min' => date('Y-m-d'),
    ])
    ?>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <?php
                if ($model->isNewRecord) {
                    echo $form->field($model, 'Files[]')->fileInput([
                        'multiple' => true,
                        'class' => 'btn btn-default btn-block',
                    ])->label('Вложения (Выбирать файлы необходимо все и сразу!)');
                } else {
                    $dir = 'Просмотр прикрепленных файлов...';
                    if (is_dir($model->si_path_attach)) {
                        if (count(scandir($model->si_path_attach)) > 2) {
                            echo Html::a($dir, Url::to(['/siteinfo/files', 'id' => $model->si_id]), ['class' => 'btn btn-info view-files', 'target' => 'blank']);
                        }
                    }
                }
                ?>
            </div>
            <div class="col-md-4  center-block">

                <?=
                Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', [
                    'class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block'])
                ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
