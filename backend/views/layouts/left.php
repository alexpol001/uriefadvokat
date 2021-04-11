<aside class="main-sidebar">

    <section class="sidebar">

        <?
        $checkController = function ($controller) {
            return $controller === $this->context->getUniqueId();
        };
        $checkAction = function ($controller, $action) use ($checkController) {
            return $checkController($controller) && Yii::$app->controller->action->id == $action;
        };
        $referenceMaterial = function ($label, $parent) use ($checkController) {
            return [
                'label' => $label,
                'url' => ['material/index', 'parent' => $parent],
                'active' => $checkController('material') && \common\models\material\Material::isHaveParent($parent),
            ];
        };

        $menuItems = function () {
            $materials = \common\models\swp\Group::findOne(1)->materials;
            return \backend\components\Menu::getMenu($materials, $this, true);
        }

        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],

                'items' => array_merge([
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                ], $menuItems())
            ]
        ) ?>
    </section>
</aside>
