<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blg_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $surname
 * @property string $name
 * @property string $password
 * @property string $salt
 * @property string $access_token
 * @property string $create_date
 *
 * @property BlgComment[] $blgComments
 * @property Blog[] $blogs
 */
class BlgUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blg_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'surname', 'name', 'password', 'salt', 'create_date'], 'required'],
            [['create_date'], 'safe'],
            [['username'], 'string', 'max' => 128],
            [['surname', 'name'], 'string', 'max' => 45],
            [['password', 'salt', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'surname' => 'Surname',
            'name' => 'Name',
            'password' => 'Password',
            'salt' => 'Salt',
            'access_token' => 'Access Token',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlgComments()
    {
        return $this->hasMany(BlgComment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['user_id' => 'id']);
    }
}
