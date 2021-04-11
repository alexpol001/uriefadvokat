<?php

use backend\components\Backend;
use dominus77\iconpicker\IconPicker;
use dominus77\tinymce\TinyMce;
use kartik\color\ColorInput;
use kartik\date\DatePicker;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\swp\models\Group */
/* @var $material \backend\modules\swp\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>

<? /** @var \backend\modules\swp\models\Field $field */
foreach ($model->swFields as $field) : ?>
    <? if ($field->type == 150) {
        $field = \common\models\swp\Field::findOne($field->params);
    } ?>
    <? $valueField = "field[$field->id]"; ?>
    <? $fieldId = 'field' . $field->id ?>
    <? $form_group = true ?>
    <?
    $value = $material->getValue($field->id);
    $value = $value ? $value : $field->default;
    ?>
    <? switch ($field->type) {
        case 0:
            $material->setLabelTitle($field->title);
            if (!$field->is_hidden) {
                $valueField = $form->field($material, 'title')->textInput(['placeholder' => true, 'class' => 'form-control value-field']);
            } else {
                $valueField = $form->field($material, 'title', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput(['value' => $model->group->title])->label(false)->error(false);
            }
            $form_group = false;
            break;
        case 200:
            $valueField = Html::textarea($valueField, $value, ['class' => 'form-control value-field', 'id' => $fieldId, 'placeholder' => $field->title]);
            break;
        case 300:
            $valueField = TinyMce::widget([
                'name' => $valueField,
                'value' => $value,
                ]);
            break;
        case 400:
            $valueField = \kartik\select2\Select2::widget([
                'name' => $valueField,
                'data' => Backend::getSelectItems($field->params),
                'options' => ['placeholder' => $field->title, 'id' => $fieldId, 'class' => 'value-field'],
                'pluginOptions' => [
                    'allowClear' => (!$field->is_require)
                ],
                'value' => $value,
            ]);
            break;
        case 500:
            $valueField = \kartik\select2\Select2::widget([
                'name' => $valueField,
                'data' => Backend::getSelectItems($field->params),
                'options' => ['id' => $fieldId, 'multiple' => true, 'class' => 'value-field'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'value' => explode(", ", $value)
            ]);
            break;
        case 600:
            $valueField = InputFile::widget([
                'language' => 'ru',
                'controller' => 'elfinder',
                'template' => '<div class="input-group elfinder">{input}<span class="input-group-btn">{button}</span></div>',
                'options' => ['class' => 'form-control value-field', 'id' => $fieldId, 'placeholder' => $field->title],
                'buttonName' => 'Выбрать файл',
                'buttonOptions' => ['class' => 'btn btn-primary'],
                'name' => $valueField,
                'value' => $value,
            ]);
            break;
        case 700:
            $valueField = InputFile::widget([
                'language' => 'ru',
                'controller' => 'elfinder',
                'template' => '<div class="input-group elfinder">{input}<span class="input-group-btn">{button}</span></div>',
                'options' => ['class' => 'form-control value-field', 'id' => $fieldId, 'placeholder' => $field->title],
                'buttonName' => 'Выбрать файлы',
                'buttonOptions' => ['class' => 'btn btn-primary'],
                'name' => $valueField,
                'value' => $value,
                'multiple' => true
            ]);
            break;
        case 800:
            $valueField = ColorInput::widget([
                'options' => ['id' => $fieldId, 'class' => 'input-color value-field', 'placeholder' => 'Выберите цвет ...'],
                'name' => $valueField,
                'value' => $value,
                'pluginOptions' => [
                    'preferredFormat' => 'rgb'
                ]
            ]);
            break;
        case 900:
            $valueField = IconPicker::widget([
                'options' => ['class' => 'form-control value-field', 'id' => $fieldId],
                'name' => $valueField,
                'value' => $value,
                'clientOptions' => [
                    'templates' => [
                        'popover' => '<div class="iconpicker-popover popover"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
                        'footer' => '<div class="popover-footer"></div>',
                        'buttons' => '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button> <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
                        'search' => '<input type="search" class="form-control iconpicker-search" placeholder="Поиск" />',
                        'iconpicker' => '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
                        'iconpickerItem' => '<a role="button" href="#" class="iconpicker-item"><i></i></a>',
                    ],
                ]
            ]);
            break;
        case 1000:
            $valueField = DatePicker::widget([
                'name' => $valueField,
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'value' => $value,
                'options' => ['class' => 'value-field',],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]);
            break;
        case 1100:
            $value = explode(", ", $value);
            $valueField = DatePicker::widget([
                'name' => ($valueField . '[0]'),
                'value' => $value[0],
                'type' => DatePicker::TYPE_RANGE,
                'options' => ['class' => 'value-field'],
                'options2' => ['class' => 'value-field'],
                'name2' => ($valueField . '[1]'),
                'value2' => $value[1],
                'separator' => 'до',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]);
            break;
        default:
            $valueField = Html::textInput($valueField, $value, ['class' => 'form-control value-field', 'id' => $fieldId, 'placeholder' => $field->title]);
    }

    ?>
    <? if ($form_group) {
        $valueField = '<div class="form-group"' . ($field->is_hidden ? ' style="display: none;">' : '>') . Html::label($field->title, $fieldId) . $valueField;
        $valueField .= $field->is_require ? '<div class="help-block"></div></div>' : '</div>';
    }
    ?>
    <?= $valueField ?>
<? endforeach; ?>
