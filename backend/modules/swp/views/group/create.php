<?php

use backend\modules\swp\models\Group;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $group Group */
/* @var $parentController string */
/* @var $model Group */

$this->title = 'Разработка материалов';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['group']];
\backend\components\Backend::getBreadCrumbGroup($this, $group);
$this->params['breadcrumbs'][] = 'Добавить группу';
?>
    <h2><?= Html::encode(end($this->params['breadcrumbs'])) ?></h2>
<?= $this->render('element/_form', [
    'model' => $model,
    'group' => $group,
    'parentController' => $parentController,
]) ?>
