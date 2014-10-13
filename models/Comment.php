<?php

namespace ostashevdv\cackle\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property string $channel
 * @property string $comment
 * @property string $date
 * @property string $autor
 * @property string $email
 * @property string $avatar
 * @property string $ip
 * @property integer $is_register
 * @property integer $approve
 * @property string $user_agent
 * @property integer $modified
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'unique'],
            [['channel', 'comment', 'autor', 'user_agent'], 'required'],
            [['channel', 'comment'], 'string'],
            [['date'], 'safe'],
            [['date', 'modified'], 'date', 'format'=>'A'],
            [['is_register', 'approve', 'modified'], 'integer'],
            [['autor', 'email'], 'string', 'max' => 128],
            [['avatar'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 16],
            [['user_agent'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Канал',
            'comment' => 'Комментарий',
            'date' => 'Дата',
            'autor' => 'автор',
            'email' => 'email',
            'avatar' => 'аватар',
            'ip' => 'Ip',
            'is_register' => 'Is Register',
            'approve' => 'Approve',
            'user_agent' => 'User Agent',
            'modified' => 'Изменено'
        ];
    }

}
