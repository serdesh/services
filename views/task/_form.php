<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Task;
use app\models\Urgency;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="task-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php
        if ($model->isNewRecord){
            echo $form->field($model, 'task_order')->hiddenInput([
                'value' => (Task::find()->max('task_order')) + 1,
            ])->label('');
        }
        ?>
        <?php $items = ArrayHelper::map(User::find()->orderBy(['fio' => 'ASC'])->all(), 'id', 'fio'); ?>

        <?= $form->field($model, 'task_user')->dropDownList($items, ['value' => Yii::$app->user->identity->id]) ?>

        <?= $form->field($model, 'task_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'task_notes')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'task_done')->hiddenInput(['value' => 0])->label('')?>

        
        <?php
        $items_urg = ArrayHelper::map(Urgency::find()->all(), 'urg_id', 'urg_name');
        ?>
        <?php echo $form->field($model, 'task_urgency')->dropDownList($items_urg, []) ?>

     
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

<?php ActiveForm::end(); ?>

    </div>
</div>