<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/**
 * @var yii\web\View $this
 * @var app\models\Event $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => 4]) ?>

    <!-- <?= $form->field($model, 'at')->textInput() ?> -->
    
    <?= $form->field($model, 'at')->widget(DateTimePicker::className(),
    [
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'value' => '23-Feb-1982 10:10',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy hh:ii'
        ]
    ]); ?>

    <!-- <?= $form->field($model, 'created')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
