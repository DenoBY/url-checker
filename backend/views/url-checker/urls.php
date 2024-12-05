<?php

use yii\grid\GridView;

$this->title = 'URLs';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'url',
        'check_interval',
        'retry_count',
        'retry_delay',
        'created_at',
        'updated_at',
    ],
]); ?>