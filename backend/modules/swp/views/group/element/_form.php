<?php

use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Group */
/* @var $parentController string */
/* @var $form yii\widgets\ActiveForm */
/* @var $group \backend\modules\swp\models\Group */
/* @var $tab string */
?>

<?php $form = ActiveForm::begin(); ?>
<?= \backend\widgets\FormWidget::widget([
    'creatable' => true,
    'copyable' => ($model->status != 100 || !$model->group),
    'close' => ($group || $model->group_id) ? [$parentController . '/update', 'id' => $group ? $group->id : $model->group_id, 'tab' => 'sub-group'] : null
]) ?>

<?
$items = [
    [
        'label' => 'Основное',
        'content' => $this->render('primary_form', [
            'form' => $form,
            'model' => $model,
            'group' => $group,
        ]),
        'options' => [
            'id' => 'basic-group',
        ],
        'active' => !($tab) || ($tab == 'basic-group')
    ],
];

if ($model->id && !Yii::$app->getRequest()->getQueryParams()['copy']) {
    if ($model->group) {
        array_push($items, [
            'label' => 'Поля',
            'content' => '',
            'options' => [
                'id' => 'sub-field'
            ],
            'active' => ($tab == 'sub-field')
        ]);
    }
    if ($model->type == 100) {
        array_push($items, [
            'label' => 'Группы',
            'content' => '',
            'options' => [
                'id' => 'sub-group',
            ],
            'active' => ($tab == 'sub-group')
        ]);
    }
}
?>

<?= Tabs::widget([
    'id' => 'tabs',
    'items' => $items
]);
?>

<?php ActiveForm::end(); ?>

<? if ($model->id && !Yii::$app->getRequest()->getQueryParams()['copy']) : ?>
    <?= $this->render('field_form', [
        'model' => $model,
        'subId' => 'sub-field'
    ]) ?>
    <? if ($model->type == 100) : ?>
        <?= $this->render('../../common/group_form', [
            'model' => $model,
            'subId' => 'sub-group'
        ]) ?>
    <? endif; ?>
    <? $this->registerJsFile(Yii::getAlias('@web') . '/js/sub-grid.js', ['depends' => [yii\web\JqueryAsset::className()]]) ?>
<? endif; ?>
