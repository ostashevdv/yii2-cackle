<?php

namespace ostashevdv\cackle\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $pubStatus
 * @property string $channel
 * @property string $message
 * @property string $dateCreate
 * @property string $dateModify
 * @property string $autor
 * @property string $email
 */
class Comment extends \yii\db\ActiveRecord
{
    /** статусы комментария */
    const STATUS_APPROVED  = 1;
    const STATUS_PENDING = 0;
    const STATUS_SPAM = -1;
    const STATUS_DELETED = -2;

    public static function getStatusArray()
    {
        return [
            self::STATUS_APPROVED => 'Одобрен',
            self::STATUS_PENDING  => 'В ожидании',
            self::STATUS_SPAM     => 'Спам',
            self::STATUS_DELETED  => 'Удалено'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pubStatus', 'integer'],
            ['pubStatus', 'default', 'value' => self::STATUS_PENDING],
            ['pubStatus', 'in', 'value' => array_keys(self::getStatusArray())],

            ['channel', 'required'],
            ['channel', 'string'],

            ['message', 'required'],
            ['message', 'string'],

            ['dateCreate', 'date', 'format'=>'Y-m-d h:i:s'],
            ['dateModify', 'date', 'format'=>'Y-m-d h:i:s'],

            ['email', 'email'],
            [['email','author'], 'string', 'max'=>128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pubStatus' => 'Статус',
            'channel' => 'Канал',
            'message' => 'Комментарий',
            'dateCreate' => 'Создан',
            'dateModify' => 'Изменен',
            'autor' => 'Автор',
            'email' => 'email',
        ];
    }
}
