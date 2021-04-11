<?php


use backend\modules\swp\models\Field;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Field */
/* @var $group \backend\modules\swp\models\Group */
/* @var $parentController string */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= \backend\widgets\FormWidget::widget([
        'creatable' => true,
        'copyable' => ($model->status != 100),
        'close' => ($model->group_id || $group) ?
            [$parentController . '/update', 'id' => $group ? $group->id : $model->group_id, 'tab' => 'sub-field']
            : [$parentController, 'tab' => 'fields']
    ]) ?>

    <?
    if ($group && !$model->type) {
        $model->type = 100;
        $model->group_id = $group->id;
    } else if (!$model->group_id) {
        $model->group_id = 0;
    }
    $common_fields = Field::getCommonFields();
    $model->common_field = array_keys($common_fields)[0];
    ?>
    <? if ($model->type == 150) {
        $model->common_field = $model->params;
        $model->params = '';
    } ?>

    <div class="form-content">

        <?= $form->field($model, 'title', ['options' => ['class' => 'title-field', 'style' => $model->type == 150 ? 'display: none;' : '']])->textInput(['maxlength' => true]) ?>

        <? if ($model->type !== 0) : ?>

            <?= $form->field($model, 'type')->widget(Select2::classname(), [
                'data' => Field::getTypes(false, ($model->group_id || $group) ? false : true),
                'options' => ['placeholder' => 'Выберите тип...', 'value' => $model->type ? $model->type : array_keys(Field::getTypes())[0]],
            ]) ?>

            <?= $form->field($model, 'default', ['options' => ['class' => 'default-field', 'style' => $model->type == 150 ? 'display: none;' : '']]) ?>

            <?= $form->field($model, 'is_require', ['options' => ['class' => 'require-field', 'style' => ($model->type == 300 || $model->type == 150) ? 'display: none;' : '']])->checkbox() ?>

            <?= $form->field($model, 'is_search', ['options' => ['class' => 'search-field', 'style' => ($model->type == 150 || !($model->type == 100 || $model->type == 400 || $model->type == 500 || $model->type == 1000 || $model->type == 1100)) ? 'display: none;' : '']])->checkbox() ?>

            <?= $form->field($model, 'params', ['options' => ['class' => 'params-field', 'style' => ($model->type == 150 || !($model->type == 400 || $model->type == 500)) ? 'display: none;' : '']])->textarea() ?>

            <?= $form->field($model, 'common_field', ['options' => ['class' => 'common-field', 'style' => $model->type != 150 ? 'display: none;' : ''], 'enableClientValidation' => false])->widget(
                Select2::classname(), [
                    'data' => $common_fields,
                ]
            ) ?>

        <? endif; ?>

        <?= $form->field($model, 'is_hidden', ['options' => ['class' => 'hidden-field', 'style' => $model->type == 150 ? 'display: none;' : '']])->checkbox() ?>

        <?= $form->field($model, 'group_id')->hiddenInput()->label(false); ?>
    </div>


    <?
    $script = <<<JS
var params = $('.params-field');
var require = $('.require-field');
var search = $('.search-field');
var title = $('.title-field');
var _default = $('.default-field');
var hidden = $('.hidden-field');
var common_field = $('.common-field');

var title_input = $('#field-title');
var common_field_input = $('#field-common_field');

var lastTitle = title_input.val();
function changeCommonTitle() {
    title_input.val(common_field_input.find("option:selected" ).text());
}
    
common_field_input.on('change', function() {
    changeCommonTitle();
});

title_input.on('change', function() {
    lastTitle = title_input.val();
});

$('#field-type').on('change', function() {
    var val = $(this).val();
    if (val == 400 || val == 500) {
        params.show();
    } else {
        params.hide();
    }
    if (val != 300 && val != 150) {
        require.show();
    } else {
        require.hide();
    }
    if ((val == 100 || val == 400 || val == 500 || val == 1000 || val == 1100) && val != 150) {
        search.show();
    } else {
        search.hide();
    }
    if (val == 150) {
        title.hide();
        _default.hide();
        hidden.hide();
        common_field.show();
        changeCommonTitle();
    } else {
        title_input.val(lastTitle);
        title.show();
        _default.show();
        hidden.show();
        common_field.hide();
    }
});
JS;
    $this->registerJs(
        $script
    ) ?>
    <?php ActiveForm::end(); ?>
</div>
