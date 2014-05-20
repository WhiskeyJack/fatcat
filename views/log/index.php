<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Log $searchModel
 */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            //'log_severity',
            'logSeverity.name',
            //'log_source_id',
            'logSource.name',
            'subject',
            'message',
            //'created',
            'created_local',
            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}',],
        ],
    ]); ?>

</div>
