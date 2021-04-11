<?php
/* @var $this yii\web\View */
/* @var $model Group */

/* @var $subId int */

use backend\widgets\GridView;
use backend\modules\swp\models\Field;
use backend\modules\swp\models\Group;

?>

<?
$searchModel = new \common\models\swp\search\Field();
$searchModel->setParent($model ? $model->id : 0);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
?>
<?= $this->render('/common/grid_view', [
    'additionalColumns' => [
        [
            'attribute' => 'type',
            'filter' => Field::getTypes(true),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Поиск по типу'],
            'format' => 'raw',
            'vAlign' => 'middle',
            'value' => function ($data) {
                return Field::getTypes(true)[$data->type];
            },
        ],
    ],
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'subId' => $subId,
    'model' => $model,
    'create' => ['/swp/field/create', 'group' => $model ? $model->id : null],
    'refresh' => ['', 'id' => $model ? $model->id : null, 'tab' => $subId],
    'delete' => ['/swp/field/multi-delete', 'group' => $model ? $model->id : 0, 'tab' => $subId],
    'urlController' => '/swp/field',
    'fullStatuses' => 1
]); ?>
