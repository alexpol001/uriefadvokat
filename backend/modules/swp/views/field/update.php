<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Field */
/* @var $parentController string */

$this->title = 'Разработка материалов';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/swp/group']];
\backend\components\Backend::getBreadCrumbGroup($this, $model->group);
$this->params['breadcrumbs'][] = $model->title .' / Редактировать поле';
?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<?= $this->render('element/_form', [
    'model' => $model,
    'parentController' => $parentController,
]) ?>
