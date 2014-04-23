<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\PeriodicEvent $model
 */

$this->title = 'Create Periodic Event';
$this->params['breadcrumbs'][] = ['label' => 'Periodic Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodic-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
