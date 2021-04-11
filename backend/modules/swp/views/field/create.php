<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Field */
/* @var $group \backend\modules\swp\models\Group */
/* @var $parentController string */

$this->title = 'Разработка материалов';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/swp/group']];
\backend\components\Backend::getBreadCrumbGroup($this, $group);
$this->params['breadcrumbs'][] = 'Добавить поле';
?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<?= $this->render('element/_form', [
    'model' => $model,
    'group' => $group,
    'parentController' => $parentController,
]) ?>
