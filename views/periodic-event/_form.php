<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\PeriodicEvent $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="periodic-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'quantity')->textInput(['maxlength' => 4]) ?>

    <?php 
    $p = new app\models\PeriodicEvent();
    $p->writeCrontab();
    $items = array();
    for ($i=0; $i < 24; $i++)
      $items[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    echo $form->field($model, 'hour')->dropDownList($items);
    
    $items = array();
    for ($i=0; $i < 60; $i++)
      $items[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
    echo $form->field($model, 'minute')->dropDownList($items); 
    ?>
    
    <?= $form->field($model, 'monday')->checkBox() ?>

    <?= $form->field($model, 'tuesday')->checkBox() ?>

    <?= $form->field($model, 'wednesday')->checkBox() ?>

    <?= $form->field($model, 'thursday')->checkBox() ?>

    <?= $form->field($model, 'friday')->checkBox() ?>

    <?= $form->field($model, 'saturday')->checkBox() ?>

    <?= $form->field($model, 'sunday')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
