<?php

use yii\db\Schema;
use yii\db\Migration;

class m141010_083737_comments extends Migration
{
    public function up()
    {
        $this->createTable('{{%comment}', [
                'id'                => Schema::TYPE_PK,
                'channel'           => Schema::TYPE_TEXT. " NOT NULL COMMENT 'Канал' ",
                'comment'           => Schema::TYPE_TEXT. " NOT NULL COMMENT 'Комментарий' ",
                'date'              => Schema::TYPE_TIMESTAMP." DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата' ",
                'autor'             => Schema::TYPE_STRING. "(128) NOT NULL COMMENT 'автор' ",
                'email'             => Schema::TYPE_STRING. "(128) NULL  COMMENT 'email' ",
                'avatar'            => Schema::TYPE_STRING. "(255) NULL DEFAULT NULL COMMENT 'аватар'",
                'ip'                => Schema::TYPE_STRING. "(16) NOT NULL DEFAULT ''",
                'is_register'       => Schema::TYPE_SMALLINT."(1) NOT NULL DEFAULT 0",
                'approve'           => Schema::TYPE_SMALLINT."(1) NOT NULL DEFAULT 1",
                'user_agent'        => Schema::TYPE_STRING. "(255) NOT NULL ",
                'modified'          => Schema::TYPE_TIMESTAMP . " DEFAULT '0000-00-00 00:00:00' COMMENT 'Изменено' "
            ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    }

    public function down()
    {
        echo "m141010_083737_comments cannot be reverted.\n";

        return false;
    }
}
