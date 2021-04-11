<?php

use backend\components\Backend;
use backend\modules\swp\models\Material;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $group \common\models\swp\Group */
/* @var $parentController string */
/* @var $model \common\models\swp\Material */
/* @var $tab string */

$materialParent = Material::findOne(Yii::$app->getRequest()->getQueryParams()['id']);
$this->title = Backend::getMaterialTitle($materialParent, $group);
if (!$group->is_singleton) {
    Backend::getBreadCrumbMaterial($this, $materialParent);
    $this->params['breadcrumbs'][] = 'Добавить';
} else {
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<? if (!$group->is_singleton) : ?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<? endif ?>
<?= $this->render('element/_form', [
    'model' => $model,
    'group' => $group,
    'parentController' => $parentController,
    'tab' => $tab,
]) ?>
