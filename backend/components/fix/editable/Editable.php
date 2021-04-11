<?php
namespace backend\components\fix\editable;

use kartik\base\Config;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Editable extends \kartik\editable\Editable
{
    /**
     * Initializes the widget options. This method sets the default values for various widget options.
     *
     * @throws InvalidConfigException
     */
    protected function initOptions()
    {
        $defaultBtnCss = $this->getDefaultBtnCss();
        if (!isset($this->resetButton['class'])) {
            $this->resetButton['class'] = 'btn btn-sm ' . $defaultBtnCss;
        }
        if (!isset($this->editableButtonOptions['class'])) {
            $this->editableButtonOptions['class'] = 'btn btn-sm ' . $defaultBtnCss;
        }
        Html::addCssClass($this->inputContainerOptions, self::CSS_PARENT);
        if ($this->asPopover !== true) {
            $this->initInlineOptions();
        }
        if ($this->hasModel()) {
            $options = ArrayHelper::getValue($this->inputFieldConfig, 'options', []);
            Html::addCssClass($options, self::CSS_PARENT);
            $this->inputFieldConfig['options'] = $options;
        }
        if (!Config::isHtmlInput($this->inputType)) {
            if ($this->widgetClass === 'kartik\datecontrol\DateControl') {
                $options = ArrayHelper::getValue($this->options, 'options.options', []);
                Html::addCssClass($options, 'kv-editable-input');
                $this->options['options']['options'] = $options;
                $this->options['widgetOptions']['options'] = $options;
            } elseif ($this->inputType !== self::INPUT_WIDGET) {
                if ($this->hasModel()) {
                    $this->options['options']['id'] .= 'edit-input-'.$this->model->id;
                }
                $options = ArrayHelper::getValue($this->options, 'options', []);
                Html::addCssClass($options, 'kv-editable-input');
                $this->options['options'] = $options;
            }
        } else {
            $css = empty($this->options['class']) ? ' form-control' : '';
            Html::addCssClass($this->options, 'kv-editable-input' . $css);
        }
        if ($this->hasModel()) {
            $this->options['id'] .= '-'.$this->model->id;
        }
        $this->_inputOptions = $this->options;
        $this->containerOptions['id'] = $this->options['id'] . '-cont';
        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        if ($value === null && !empty($this->valueIfNull)) {
            $value = $this->valueIfNull;
        }
        if (!isset($this->displayValue)) {
            $this->displayValue = $value;
        }
        if ($this->valueIfNull === null || $this->valueIfNull === '') {
            $this->valueIfNull = '<em>' . Yii::t('kveditable', '(not set)') . '</em>';
        }
        if ($this->displayValue === null || $this->displayValue === '') {
            $this->displayValue = $this->valueIfNull;
        }
        $hasDisplayConfig = is_array($this->displayValueConfig) && !empty($this->displayValueConfig);
        if ($hasDisplayConfig && (is_array($this->value) || is_object($this->value))) {
            throw new InvalidConfigException(
                "Your editable value cannot be an array or object for parsing with 'displayValueConfig'. The array keys in 'displayValueConfig' must be a simple string or number. For advanced display value calculations, you must use your controller AJAX action to return 'output' as a JSON encoded response which will be used as a display value."
            );
        }
        if ($hasDisplayConfig && isset($this->displayValueConfig[$value])) {
            $this->displayValue = $this->displayValueConfig[$value];
        }
        Html::addCssClass($this->containerOptions, 'kv-editable');
        Html::addCssClass($this->contentOptions, 'kv-editable-content');
        Html::addCssClass($this->formOptions['options'], 'kv-editable-form');
        $class = 'kv-editable-value';
        if ($this->format == self::FORMAT_BUTTON) {
            if (!$this->asPopover) {
                $before = ArrayHelper::getValue($this->inlineSettings, 'templateBefore', '');
                if ($before === self::INLINE_BEFORE_1) {
                    Html::addCssClass($this->containerOptions, 'kv-editable-inline-1');
                } elseif ($before === self::INLINE_BEFORE_2) {
                    Html::addCssClass($this->containerOptions, 'kv-editable-inline-2');
                }
            }
            Html::addCssClass($this->editableButtonOptions, 'kv-editable-button');
        } elseif (empty($this->editableValueOptions['class'])) {
            $class = ['kv-editable-value', 'kv-editable-link'];
        }
        Html::addCssClass($this->editableValueOptions, $class);
        $this->_popoverOptions['type'] = $this->type;
        $this->_popoverOptions['placement'] = $this->placement;
        $this->_popoverOptions['size'] = $this->size;
        if (!isset($this->preHeader)) {
            $this->preHeader = $this->defaultPreHeaderIcon . ' ' . Yii::t('kveditable', 'Edit') . ' ';
        }
        if ($this->header == null) {
            $attribute = $this->attribute;
            if (strpos($attribute, ']') > 0) {
                $tags = explode(']', $attribute);
                $attribute = array_pop($tags);
            }
            $this->_popoverOptions['header'] = $this->preHeader .
                ($this->hasModel() ? $this->model->getAttributeLabel($attribute) : '');
        } else {
            $this->_popoverOptions['header'] = $this->preHeader . $this->header;
        }
        $this->_popoverOptions['footer'] = $this->renderFooter();
        $this->_popoverOptions['options']['class'] = 'kv-editable-popover skip-export';
        if ($this->format == self::FORMAT_BUTTON) {
            if (empty($this->editableButtonOptions['label'])) {
                $this->editableButtonOptions['label'] = $this->defaultEditableBtnIcon;
            }
            Html::addCssClass($this->editableButtonOptions, 'kv-editable-toggle');
            $this->_popoverOptions['toggleButton'] = $this->editableButtonOptions;
        } else {
            $this->_popoverOptions['toggleButton'] = $this->editableValueOptions;
            $this->_popoverOptions['toggleButton']['label'] = $this->displayValue;
        }
        if (!empty($this->footer)) {
            Html::addCssClass($this->_popoverOptions['options'], 'has-footer');
        }
    }

    protected function renderInput()
    {
        $list = Config::isDropdownInput($this->inputType);
        $input = $this->inputType;
        if ($this->hasModel()) {
            if (isset($this->_form)) {
                $this->_inputOptions['id'] .= '-'.$this->model->id;
                $field = $this->getField();
                return $list ? $field->$input($this->data, $this->_inputOptions) : $field->$input($this->_inputOptions);
            }
            $input = 'active' . ucfirst($this->inputType);
        }
        $value = $this->value;
        if ($input === 'radio' || $input === 'checkbox') {
            $this->options['value'] = $value;
            $value = ArrayHelper::remove($this->_inputOptions, 'checked', false);
        }
        if ($list) {
            $field = Html::$input($this->name, $value, $this->data, $this->_inputOptions);
        } else {
            $field = Html::$input($this->name, $value, $this->_inputOptions);
        }
        return $this->getOutput($field);
    }
}
