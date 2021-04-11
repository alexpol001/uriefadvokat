<?php

/* @var $model \backend\modules\swp\models\Group */
/* @var $material \backend\modules\swp\models\Material */
/* @var $subId int */
/* @var $subClass string */

?>
<?
$searchModel = new \common\models\swp\search\Material();
$searchModel->setParent($model->id, $material->id);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
?>
<?= $this->render('/common/grid_view', [
    'additionalColumns' => \backend\components\Backend::getSearchColumns($searchModel->group_id),
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'subId' => $subId,
    'model' => $material,
    'create' => ['create', 'id' => $material->id, 'group' => $model->id],
    'refresh' => ['', 'id' => $material->id, 'tab' => $subId],
    'delete' => ['material/multi-delete', 'group' => $material->id, 'tab' => $subId],
    'urlController' => '/swp/material',
    'subClass' => $subClass,
]); ?>
