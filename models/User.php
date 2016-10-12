<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * @property mixed access_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return mixed
     */
    public static function tableName()
    {
        return 'prm_user';
    }

    /**
     * @return mixed
     */
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password'], 'required'],
            ['usernamw', 'email'],
            ['usernamw', 'unique'],
        ];
    }

    /**
     * @return mixed
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'surname' => 'Surname',
            'online' => 'Online',
            'password' => 'Password',
            'salt' => 'Salt',
            'access_token' => 'Access Token',

        ];
    }

    /**
     * @return mixed
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord() && !empty($this->password))
            {
                $this->salt = $this->saltGenerator();
            }
            if (!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password, $this->salt);
            }
            else {
                unset ($this->password);
            }
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function saltGenerator()
    {
        return hash("sha512", uniqid('salt', true));
    }

    /**
     * @return mixed
     * @param $password
     * @param string
     */
    public function passWithSalt($password, $salt)
    {
        return hash("sha512", $password, $salt);
    }

//    public $id;
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;
//
//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' =>$id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' =>$username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey()["id"];
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    /**
     * @return mixed
     */
    public function validatePassword($password)
    {
        return $this->password = $this->passWithSalt($password, $this->salt);
    }

    public function setPassword($password)
    {
       $this->password = $this->passWithSalt($password, $this->saltGenerator());
    }
}
