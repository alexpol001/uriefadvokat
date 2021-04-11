<?php

use backend\components\Backend;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $parentController string */
/* @var $model \backend\modules\swp\models\Material */
/* @var $tab string */

$group = $model->group;
$this->title = Backend::getMaterialTitle($model->getMaterialParent(), $group);;
if (!$group->is_singleton) {
    Backend::getBreadCrumbMaterial($this, $model->getMaterialParent());
    $this->params['breadcrumbs'][] = $model->title .' / Редактировать';
} else {
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<? if (!$group->is_singleton) : ?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<? endif; ?>
<?= $this->render('element/_form', [
    'model' => $model,
    'parentController' => $parentController,
    'tab' => $tab,
]) ?>
