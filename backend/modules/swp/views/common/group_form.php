<?php

/* @var $model Group */

/* @var $subId int */

use backend\modules\swp\models\Group;

?>
<?
$searchModel = new \common\models\swp\search\Group();
$searchModel->setParent($model->id);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
?>

<?= $this->render('/common/grid_view', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'subId' => $subId,
    'model' => $model,
    'create' => ['/swp/group/create', 'group' => $model->id],
    'refresh' => ['', 'id' => $model->id, 'tab' => $subId],
    'delete' => ['/swp/group/multi-delete', 'group' => $model->id, 'tab' => $subId],
    'fullStatuses' => 1,
    'urlController' => '/swp/group',
]); ?>
