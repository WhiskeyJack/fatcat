<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\LogSeverity $model
 */

$this->title = 'Update Log Severity: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Log Severities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-severity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
