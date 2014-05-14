<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Log $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
