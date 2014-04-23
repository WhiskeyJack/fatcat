<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Event $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'event_type_id')->textInput(['maxlength' => 10]) ?> !-->
    
    <?php $list = Html::activeDropDownList($model, 'event_type_id', \yii\helpers\ArrayHelper::map(app\models\EventType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'event_type_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\EventType::find()->all(), 'id', 'name'))  ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
   
