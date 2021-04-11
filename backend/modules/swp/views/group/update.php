<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $group \backend\modules\swp\models\Group */
/* @var $parentController string */
/* @var $model \backend\modules\swp\models\Group */
/* @var $tab string */

$this->title = 'Разработка материалов';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/swp/group']];
\backend\components\Backend::getBreadCrumbGroup($this, $model->group);
$this->params['breadcrumbs'][] = $model->title .' / Редактировать группу';
?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<?= $this->render('element/_form', [
    'model' => $model,
    'parentController' => $parentController,
    'tab' => $tab,
]) ?>
