<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\PeriodicEvent $model
 */

$this->title = 'Update Periodic Event: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Periodic Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="periodic-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>