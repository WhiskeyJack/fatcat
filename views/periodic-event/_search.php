<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\PeriodicEvent $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="periodic-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'event_type_id') ?>

    <?= $form->field($model, 'every_day') ?>

    <?= $form->field($model, 'monday') ?>

    <?= $form->field($model, 'tuesday') ?>

    <?php // echo $form->field($model, 'wednesday') ?>

    <?php // echo $form->field($model, 'thursday') ?>

    <?php // echo $form->field($model, 'friday') ?>

    <?php // echo $form->field($model, 'saturday') ?>

    <?php // echo $form->field($model, 'sunday') ?>

    <?php // echo $form->field($model, 'interval_in_sec') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
