<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $discription
 * @property string $article
 * @property string $blogcol
 * @property string $create_date
 *
 * @property BlgComment[] $blgComments
 * @property BlgUser $user
 */
class Blog extends \yii\db\ActiveRecord
{
    const DESCRIPTION_MAX_LENGHT =255;
    const ARTICLE_MAX_LENGHT =65000;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'discription', 'article', 'blogcol', 'create_date'], 'required'],
            [['user_id'], 'integer'],
            [['blogcol'], 'string'],
            [['create_date'], 'safe'],
            [['discription'], 'string', 'max' => self::DESCRIPTION_MAX_LENGHT],
            [['article'], 'string', 'max' => self::ARTICLE_MAX_LENGHT],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlgUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'discription' => 'Discription',
            'targetClass' => User::className(),
            'targetAttribute'=> 'id',
            'article' => 'Article',
            'blogcol' => 'Blogcol',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlgComments()
    {
        return $this->hasMany(BlgComment::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return BlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogQuery(get_called_class());
    }
}
