<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\LogSource $model
 */

$this->title = 'Create Log Source';
$this->params['breadcrumbs'][] = ['label' => 'Log Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
