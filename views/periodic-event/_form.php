<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/**
 * @var yii\web\View $this
 * @var app\models\PeriodicEvent $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="periodic-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'event_type_id')->textInput(['maxlength' => 11]) ?> -->

    <?php $list = Html::activeDropDownList($model, 'event_type_id', \yii\helpers\ArrayHelper::map(app\models\EventType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'event_type_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\models\EventType::find()->all(), 'id', 'name'))  ?>
    
    <?= $form->field($model, 'every_day')->checkbox() ?>

    <?= $form->field($model, 'monday')->checkbox() ?>

    <?= $form->field($model, 'tuesday')->checkbox() ?>

    <?= $form->field($model, 'wednesday')->checkbox() ?>

    <?= $form->field($model, 'thursday')->checkbox() ?>

    <?= $form->field($model, 'friday')->checkbox() ?>

    <?= $form->field($model, 'saturday')->checkbox() ?>

    <?= $form->field($model, 'sunday')->checkbox() ?>

    <?= $form->field($model, 'interval_in_sec')->textInput() ?>

    
    <!-- <?= $form->field($model, 'start_date')->textInput() ?> -->

    <?php // http://stackoverflow.com/questions/23092188/how-to-implement-kartik-yii2-fileinput-in-form-which-is-using-different-model ?>
    <?= $form->field($model, 'start_date')->widget(DateTimePicker::className(),
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
