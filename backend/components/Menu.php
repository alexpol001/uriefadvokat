<?php

namespace backend\components;


use backend\modules\swp\models\Material;
use Yii;
use yii\base\Component;

class Menu extends Component
{
    const HIDDEN_ELEMENTS = '1';

    private static function checkController($controller, $view)
    {
        return $controller === $view->context->getUniqueId();
    }

    private static function checkAction($controller, $action, $view)
    {
        return self::checkController($controller, $view) && Yii::$app->controller->action->id == $action;
    }

    private static function referenceMaterial($label, $group, $view)
    {
        return [
            'label' => $label,
            'url' => ['/swp/material/index', 'group' => $group],
            'active' => self::checkController('swp/material', $view) && Material::hasGroup($group),
        ];
    }

    public static function getMenu($materials, $view, $full = false)
    {
        $items = [];
        if (!$materials) return $items;
        /** @var Material $material */
        foreach ($materials as $material) {
            if (!$material || !$material->status || ($full && $material->getValue(6)) || in_array($material->id, explode(", ",self::HIDDEN_ELEMENTS))) {
                continue;
            }
            $icon = explode("fa-", $material->getValue(2))[1];
            $label = $material->title;
            $item = [
                'label' => $label,
                'icon' => $icon,
                'url' => '#',
            ];
            if ($controller = $material->getValue(3)) {
                $url = '/'.$controller;
                if ($action = $material->getValue(4)) {
                    $active = self::checkAction($controller, $action, $view);
                    $url .= '/' . $action;
                } else {
                    $active = self::checkController($controller, $view);
                }
                $item['url'] = [$url];
                if ($activeControllers = $material->getValue(7)) {
                    foreach (explode("|", $activeControllers) as $elem) {
                        if (!$active && self::checkController($elem, $view)) {
                            $active = true;
                            break;
                        }
                    }
                }
                $item['active'] = $active;
            } else if ($group_id = explode("_", $material->getValue(5))[1]) {
                $item = self::referenceMaterial($label, $group_id, $view);
                $item['icon'] = $icon;
            } else {
                $item['items'] = self::getMenu($material->getMaterialsByFieldValue(6, 'm_'.$material->id, [$material->id]), $view);
            }
            $items[] = $item;
        }
        return $items;
    }
}
