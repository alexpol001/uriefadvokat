<?php

use backend\modules\swp\models\Field;
use backend\modules\swp\models\Group;
use backend\modules\swp\models\Material;
use yii\db\Migration;

class m130524_201442_init extends Migration
{

    private function createUser($tableOptions)
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    private function createSwpGroup($tableOptions)
    {
        $this->createTable('{{%swp_group}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),

            'is_singleton' => $this->boolean()->notNull()->defaultValue(0),
            'type' => $this->smallInteger()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()
        ], $tableOptions);
    }

    private function createSwpField($tableOptions)
    {
        $this->createTable('{{%swp_field}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'default' => $this->text()->notNull(),
            'params' => $this->text()->null(),

            'is_require' => $this->boolean()->notNull()->defaultValue(0),
            'is_hidden' => $this->boolean()->notNull()->defaultValue(0),
            'is_search' => $this->boolean()->notNull()->defaultValue(0),
            'type' => $this->smallInteger()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()
        ], $tableOptions);
    }

    private function createSwpMaterial($tableOptions)
    {
        $this->createTable('{{%swp_material}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),

            'sort' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    private function createSwpMaterialField($tableOptions)
    {
        $this->createTable('{{%swp_material_field}}', [
            'id' => $this->primaryKey(),
            'material_id' => $this->integer()->notNull(),
            'field_id' => $this->integer()->notNull(),
            'value' => $this->text()->notNull()
        ], $tableOptions);
    }

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createUser($tableOptions);
        $this->createSwpGroup($tableOptions);
        $this->createSwpField($tableOptions);
        $this->createSwpMaterial($tableOptions);
        $this->createSwpMaterialField($tableOptions);
        $this->initSWP();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%swp_group}}');
        $this->dropTable('{{%swp_field}}');
        $this->dropTable('{{%swp_material}}');
        $this->dropTable('{{%swp_material_field}}');
    }

    private function initSWP()
    {
        $menuGroup = Group::create('????????', 100, 0, 1);

        if ($menuGroup) {
            if ($basicGroup = Group::findOne(['group_id' => $menuGroup->id])) {
                $fieldIcon = Field::create('????????????', 900, $basicGroup->id, 'fa-circle-o');

                $groupLink = Group::create('??????????', 0, $menuGroup->id, 1);
                if ($groupLink) {
                    $fieldController = Field::create('????????????????????', 100, $groupLink->id);
                    $fieldAction = Field::create('????????????????', 100, $groupLink->id);
                    $fieldLink = Field::create('???????????? ???? ???????????????????????? ????????????????', 400, $groupLink->id, '', '{"groups" : [0]}');
                    $fieldParent = Field::create('???????????????????????? ????????', 400, $groupLink->id, '', '{"groups" : [1]}');
                    $fieldAddController = Field::create('???????????????????????????? ?????????????????????? ?????? ??????????????????', 100, $groupLink->id);

                    $menuItemDev = Material::create('????????????????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-cogs'
                        ]
                    ]);

                    Material::create('????????????????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-circle-o',
                            $fieldController->id => 'swp/group',
                            $fieldParent->id => 'm_' . $menuItemDev->id,
                            $fieldAddController->id => 'swp/field',
                        ]
                    ]);

                    Material::create('????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-circle-o',
                            $fieldLink->id => 'g_' . $menuGroup->id,
                            $fieldParent->id => 'm_' . $menuItemDev->id,
                        ]
                    ]);

                    Material::create('???????????????? ????????????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-files-o',
                            $fieldController->id => 'site',
                            $fieldAction->id => 'files',
                        ]
                    ]);

                    Material::create('????????????????????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-users',
                            $fieldController->id => 'user',
                        ]
                    ]);
                } else {
                    return;
                }
            } else {
                return;
            }
        } else {
            return;
        }

        $settingGroup = Group::create('??????????????????', 100, 0, 1, 1);
        if ($settingGroup) {
            if ($basicGroup = Group::findOne(['group_id' => $settingGroup->id])) {
                Field::create('???????????????? ?????????? (?????????????????????????? ???? ?????????? 160 ????????????????', 200, $basicGroup->id);

                $groupMail = Group::create('??????????', 0, $settingGroup->id, 1);
                if ($groupMail) {
                    Field::create('???????????????? ????????????????', 400, $groupMail->id, '0', '{"items" : ["Mail", "SMTP"]}');
                    Field::create('SMTP ?????? ??????????????', 100, $groupMail->id);
                    Field::create('SMTP ??????????', 100, $groupMail->id);
                    Field::create('SMTP ????????????', 100, $groupMail->id);
                    Field::create('SMTP ????????', 100, $groupMail->id);
                    Field::create('SMTP ???????????????? ????????????????????', 100, $groupMail->id);

                    Material::create('??????????????????', $menuGroup->id, 0, [
                        'field' => [
                            $fieldIcon->id => 'fa-cog',
                            $fieldLink->id => 'g_' . $settingGroup->id,
                        ]
                    ]);
                } else {
                    return;
                }
            } else {
                return;
            }
        }
    }
}
