<?php
namespace common\components;


use common\models\swp\Field;
use common\models\swp\Group;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Common extends \yii\base\Component
{

    /**
     * @param $array ActiveQuery|array
     * @param null $totallyDelete
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteAll($array, $totallyDelete = null)
    {
        /** @var $item ActiveRecord */
        foreach ($array as $item) {
            if ($totallyDelete) {
                /** @var Field|Group $item */
                $item->delete($totallyDelete);
            } else {
                $item->delete();
            }
        }
        return true;
    }

    public static function plural_form($number, $after) {
        $cases = array(2,0,1,1,1,2);
        return $number.' '.$after[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]];
    }
}
