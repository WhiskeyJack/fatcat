<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\LogSeverity $model
 */

$this->title = 'Create Log Severity';
$this->params['breadcrumbs'][] = ['label' => 'Log Severities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-severity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
