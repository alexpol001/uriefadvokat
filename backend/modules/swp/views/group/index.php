<?php
/* @var $this yii\web\View */
/* @var $searchModel \common\models\swp\search\Group */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tab string */

$this->title = 'Разработка материалов';
$this->params['breadcrumbs'][] = $this->title;
$tab = Yii::$app->getRequest()->getQueryParams()['tab'];

use yii\bootstrap\Tabs; ?>

<?= Tabs::widget([
    'id' => 'tabs',
    'items' => [
        [
            'label' => 'Группы',
            'content' => '',
            'options' => [
                'id' => 'groups'
            ],
            'active' => !($tab) || ($tab == 'groups')
        ],
        [
            'label' => 'Общие поля',
            'content' => '',
            'options' => [
                'id' => 'fields'
            ],
            'active' => ($tab == 'fields')
        ],
    ],
]);
?>
<?=
$this->render('/common/grid_view', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'fullStatuses' => 2,
    'urlController' => '/swp/group',
    'subId' => 'groups',
    'title' => $this->title,
])
?>
<?=
$this->render('element/field_form', [
    'subId' => 'fields'
]);
?>
<? $this->registerJsFile(Yii::getAlias('@web') . '/js/sub-grid.js', ['depends' => [yii\web\JqueryAsset::className()]]) ?>

<?
$script = <<<JS
        function addLocationTag(target) {
        var noHashURL;
            if (window.location.href.search(/.*.\?tab=.*/) < 0) {
                noHashURL = window.location.href.replace(/$/, '?tab='+target);
            } else {
                noHashURL = window.location.href.replace(/\?tab=.*$/, '?tab='+target);
            }
        window.history.replaceState('', document.title, noHashURL)
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href").slice(1);
        $('input[name="tab"]').val(target);
        addLocationTag(target);
    });
JS;
$this->registerJs($script, \yii\web\View::POS_READY); ?>
