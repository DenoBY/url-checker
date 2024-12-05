<?php

use yii\grid\GridView;

$this->title = 'Checks';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'url',
            'value' => 'url.url',
        ],
        'status_code',
        'created_at',
        'updated_at',
    ],
]); ?>