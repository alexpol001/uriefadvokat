<?php

use common\models\swp\Group;

/* @var $this yii\web\View */
/* @var $searchModel \common\models\swp\search\Material */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Group::findOne($searchModel->group_id)->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/common/grid_view', [
    'additionalColumns' => \backend\components\Backend::getSearchColumns($searchModel->group_id),
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'urlController' => '/swp/material',
    'title' => $this->title,
    'create' => ['create', 'group' => $searchModel->group_id],
    'refresh' => ['', 'group' => $searchModel->group_id],
    'delete' => ['multi-delete', 'group' => $searchModel->group_id],
]);
?>
