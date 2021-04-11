<?php

namespace common\models\setting;

use common\models\swp\Group;
use yii\base\Model;

/**
 * @property string $title
 * @property string $description
 */
class Base extends Model
{
    public $title;
    public $description;
    public $politics;
    public $index;
    public $phone;
    public $address;
    public $map;

    public function init()
    {
        if ($material = Group::findOne(4)->material) {
            $this->title = $material->title;
            $this->description = $material->getValue(9);
            $this->index = $material->getValue(25);
            $this->phone = $material->getValue(26);
            $this->address = $material->getValue(27);
            $this->map = $material->getValue(28);
            $this->politics = $material->getValue(29);
        }
        parent::init();
    }
}
