<?php

use backend\modules\swp\models\Group;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Material */
/* @var $parentController string */
/* @var $form yii\widgets\ActiveForm */
/* @var $group Group */
/* @var $tab string */
?>

<?php $form = ActiveForm::begin(['id' => 'material-form', 'enableClientValidation' => false,]); ?>

<? if ($group) {
    $model->group_id = $group->id;
    echo $form->field($model, 'group_id', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false)->error(false);
    $model->material_id = Yii::$app->getRequest()->getQueryParams()['id'];
    echo $form->field($model, 'material_id', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false)->error(false);
}
?>

<?= \backend\widgets\FormWidget::widget([
    'creatable' => true,
    'copyable' => true,
    'onlySave' => $group ? ($group->is_singleton ? true : false) : ($model->group->is_singleton ? true : false),
    'close' => ($model->material_id) ? [$parentController . '/update', 'id' => $model->getMaterialParent()->id, 'tab' => 'group' . ($group ? $group->id : $model->group_id)] : [$parentController, 'group' => $model->group->id]
]) ?>

<?
$items = [];
/** @var Group $group */
$groups = $group ? $group->groups : $model->group->groups;
foreach ($groups as $key => $group_1) {
    if ($group && $group_1->type == 100) continue;
    $tabId = 'group' . $group_1->id;
    $subTabId = "sub-" . $tabId;
    array_push($items, [
        'label' => $group_1->title,
        'content' => $group_1->swFields ?
            $this->render('_fields', [
                'form' => $form,
                'model' => $group_1,
                'material' => $model
            ])
            : '',
        'options' => [
            'id' => $tabId
        ],
        'active' => ($tab == $tabId || (!$key && !$tab))
    ]);
}
?>

<?= Tabs::widget([
    'id' => 'tabs',
    'items' => $items
]);
?>

<?php ActiveForm::end(); ?>
<? if (!$group) : ?>
    <? foreach ($groups as $group) {
        if ($group->type == 100) {
            echo $this->render('grid_form', [
                'model' => $group,
                'material' => $model,
                'subId' => 'group' . $group->id,
                'subClass' => $group->swFields ? 'sub-field' : null,
            ]);
        }
    }
    ?>
<? endif; ?>
<? $this->registerJsFile(Yii::getAlias('@web') . '/js/sub-grid.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
