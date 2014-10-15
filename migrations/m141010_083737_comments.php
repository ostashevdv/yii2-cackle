<?php

use yii\db\Schema;
use yii\db\Migration;

class m141010_083737_comments extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comment}}', [
                'id'                => Schema::TYPE_PK,
                'pubStatus'         => Schema::TYPE_SMALLINT."(1) NOT NULL DEFAULT 0 COMMENT 'Статус'",
                'channel'           => Schema::TYPE_TEXT. " NOT NULL COMMENT 'Канал' ",
                'message'           => Schema::TYPE_TEXT. " NOT NULL COMMENT 'Комментарий' ",
                'dateCreate'        => Schema::TYPE_TIMESTAMP." DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создан' ",
                'dateModify'        => Schema::TYPE_TIMESTAMP." DEFAULT '0000-00-00 00:00:00' COMMENT 'Изменен' ",
                'autor'             => Schema::TYPE_STRING. "(128) NOT NULL COMMENT 'Автор' ",
                'email'             => Schema::TYPE_STRING. "(128) NULL  COMMENT 'email' ",
            ], $tableOptions);
    }

    public function down()
    {
        echo "m141010_083737_comments cannot be reverted.\n";

        return false;
    }
}
