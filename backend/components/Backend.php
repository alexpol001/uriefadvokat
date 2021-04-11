<?php

namespace backend\components;

use backend\modules\swp\models\Field;
use backend\modules\swp\models\Group;
use backend\modules\swp\models\Material;
use Yii;
use yii\base\Component;
use yii\helpers\Html;

class Backend extends Component
{

    public static function getBreadCrumbGroup($view, $parent)
    {
        $parents = [];
        while ($parent) {
            $parents[] = $parent;
            try {
                $parent = $parent->parent;
            } catch (\Exception $exception) {
                $parent = null;
            }
        }

        /** @var \common\models\material\Material|Group $parent */
        foreach (array_reverse($parents) as $parent) {
            $view->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['group/update', 'id' => $parent->id]];
        }
    }

    /**
     * @param $view
     * @param Material $parent
     */
    public static function getBreadCrumbMaterial($view, $parent)
    {
        $parents = [];
        while ($parent) {
            $parents[] = $parent;
            try {
                $parent = $parent->getMaterialParent();
            } catch (\Exception $exception) {
                $parent = false;
            }
        }

        /** @var \common\models\material\Material|Group $parent */
        foreach (array_reverse($parents) as $parent) {
            $view->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['material/update', 'id' => $parent->id]];
        }
    }

    /**
     * @param Material $materialParent
     * @param null|Group $parent
     * @return string
     */
    public static function getMaterialTitle($materialParent, $parent = null)
    {
        $materialParents = [];
        while ($materialParent) {
            $materialParents[] = $materialParent;
            $materialParent = $materialParent->getMaterialParent();
        }
        $title = $parent->title;
        /** @var Material $materialParent */
        foreach ($materialParents as $materialParent) {
            $title = $materialParent->title . ' / ' . $title;
        }
        return $title;
    }

    public static function getSelectItems($json)
    {
        $json = json_decode($json);
        $items = $json->items;
        if ($groups = $json->groups) {
            foreach ($groups as $group_id) {
                if ($group = Group::findOne($group_id)) {
                    /** @var Material $material */
                    foreach ($group->materials as $material) {
                        $items['m_'.$material->id] = $material->title;
                    }
                } else if ($group_id === 0) {
                    foreach (Group::findAll(['group_id' => $group_id]) as $group) {
                        $items['g_'.$group->id] = $group->title;
                    }
                }
            }
        }
        return $items;
    }

    public static function getSearchColumns($group_id)
    {
        $searchColumns = [];
        foreach (Group::findOne($group_id)->groups as $group) {
            /** @var \common\models\material\Field $field */
            foreach ($group->swFields as $field) {
                if ($field->is_search) {
                    $searchColumns[] = [
                        'label' => $field->title,
                        'filter' => self::getFilterInput($field),
                        'value' => function ($data) use ($field) {
                            /** @var \common\models\material\Material $data */
                            switch ($field->type) {
                                case 400:
                                    $list = Backend::getSelectItems($field->params);
                                    $value = $list[$data->getValue($field->id)];
                                    break;
                                case 500:
                                    $list = Backend::getSelectItems($field->params);
                                    $value = '';
                                    foreach (explode(", ", $data->getValue($field->id)) as $i) {
                                        $value .= '<div>'.$list[$i].'</div>';
                                    }
                                    break;
                                case 1100:
                                    $dates = explode(", ", $data->getValue($field->id));
                                    $value = ($dates[0] && $dates[1]) ? $dates[0]. ' <i class="fa fa-long-arrow-right"></i> '. $dates[1] : '';
                                    break;
                                default:
                                    $value = $data->getValue($field->id);
                            }
                            return $value;
                        },
                        'format' => 'html',
                    ];
                }
            }
        }
        return $searchColumns;
    }

    protected static function getFilterInput($field)
    {
        $filterName = 'field[' . $field->id . ']';
        $value = Yii::$app->getRequest()->getQueryParams()['field'][$field->id];
        switch ($field->type) {
            case 400:
            case 500:
                $data[''] = null;
                $data = array_merge($data, self::getSelectItems($field->params));
                $filter = Html::dropDownList($filterName, $value, $data, ['class' => 'form-control']);
//                $filter = \kartik\select2\Select2::widget([
//                    'name' => $filterName,
//                    'data' => $data,
//                    'options' => ['placeholder' => '', 'id' => 'field-'.$field->id, 'class' => 'select2-search'],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                    ],
//                    'value' => $value
//                ]);
                break;
            case 1000:
            case 1100:
//                $filter = DatePicker::widget([
//                    'name' => $filterName,
//                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
//                    'value' => $value,
//                    'pluginOptions' => [
//                        'autoclose' => true,
//                        'format' => 'dd/mm/yyyy'
//                    ]
//                ]);
//                break;
            default:
                $filter = Html::textInput($filterName, $value, ['class' => 'form-control']);
        }
        return $filter;
    }

    /**
     * @param $array
     * @param null $totallyDelete
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteAll($array, $totallyDelete = null)
    {
        /** @var Field|Group|Material $item */
        foreach ($array as $key => $item) {
            if ($totallyDelete) {
                $item->delete($totallyDelete);
            } else {
                $item->delete();
            }
        }
        return true;
    }
}
