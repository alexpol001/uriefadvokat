<?php

namespace common\models\swp\inherit;


use common\models\swp\Group;
use yii\db\ActiveQuery;
/**
 * @property ActiveQuery|Group $group
 * @property string $title
 * @property int $group_id
 */
abstract class Common extends \yii\db\ActiveRecord
{
    const SCENARIO_EDIT = 'edit';
    protected $copy = null;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_EDIT] = ['sort', 'status'];
        return $scenarios;
    }

    protected static $statuses = [
        '0' => 'Отключено',
        '10' => 'Включено',
        '100' => 'Обязательно',
    ];

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Артикль',
            'title' => 'Название',
            'group_id' => 'Группа',
            'sort' => 'Порядок сортировки',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Group
     */
    public function getGroup() {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    public function setCopy($copy) {
        $this->copy = $copy;
    }

    /**
     * @param int $groupId
     * @return mixed
     */
    public abstract function toCopy($groupId);

    /**
     * @param bool $full
     * @return array
     */
    public static function getStatuses($full = false)
    {
        $statuses = self::$statuses;
        if (!$full) {
            unset($statuses[100]);
        }
        return $statuses;
    }

    /**
     * @param null $params
     * @return Common|int
     */
    protected function generateSortValue($params = null)
    {
        if (!$params) {
            $params = ['group_id' => $this->group ? $this->group->id : 0];
        }
        /** @var self $query */
        $query = self::find()->andWhere($params)->max('sort');
        if ($query == null) return 0;
        return ($query >= 0) ? ($query >= 0 ? $query+10 : 0) : 0;
    }
}
