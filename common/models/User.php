<?php

namespace common\models;

use common\behaviors\FileBehavior;
use common\models\query\UserQuery;
use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $photo
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property string $fullName
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    public $photo_upload;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_CLIENT = 'client';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';


    /**
     * @param $name string
     * @return array
     */
    public static function getLabels($name)
    {
        $labels = [
            'status' => [
                self::STATUS_ACTIVE => Yii::t('app', 'Включено'),
                self::STATUS_DELETED => Yii::t('app', 'Виключено'),
            ],
            'role' => [
                self::ROLE_CLIENT => Yii::t('app', 'Клієнт'),
                self::ROLE_MANAGER => Yii::t('app', 'Менеджер'),
                self::ROLE_ADMIN => Yii::t('app', 'Адмін'),
            ]
        ];

        return $labels[$name];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name', 'email', 'phone'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['photo', 'phone', 'first_name', 'last_name', 'middle_name', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_reset_token', 'email', 'phone'], 'unique'],
            [['email'], 'email'],
            [['photo_upload'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['phone'], 'validatePhone'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'E-mail'),
            'phone' => Yii::t('app', 'Телефон'),
            'fullName' => Yii::t('app', 'Повне ім\'я'),
            'first_name' => Yii::t('app', 'Ім\'я'),
            'last_name' => Yii::t('app', 'Прізвище'),
            'middle_name' => Yii::t('app', 'По батькові'),
            'photo' => Yii::t('app', 'Фото'),
            'photo_upload' => Yii::t('app', 'Фото'),
            'status' => Yii::t('app', 'Статус'),
            'role' => Yii::t('app', 'Роль'),
            'password' => 'Пароль',
            'updated_at' => Yii::t('app', 'Оновлений'),
            'created_at' => Yii::t('app', 'Створений'),

            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => FileBehavior::className(),
                'options' => [
                    'photo_upload' => [
                        'name' => 'photo',
                        'type' => 'image',
                        'width' => 200,
                        'height' => 200
                    ],
                ]
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->generateAuthKey();
            return true;
        }

        return false;
    }

    public function afterFind()
    {
        if (!$this->photo) $this->photo = '/img/no_avatar.png';

        return parent::afterFind();
    }

    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!preg_match("/^[\d]+$/", $this->phone) || strlen($this->phone) != 9) {
                $this->addError($attribute, Yii::t('app', 'Некоретний телефон'));
            }
        }
    }

    /**
     * @param $role string
     * @param $status string
     * @return array
     */
    static function getAllNames($role, $status = null){
        $clients = ArrayHelper::map(
            User::find()->select([
                'id',
                'fullName' => 'CONCAT('.User::tableName().'.first_name, " ", '.User::tableName().'.last_name, " ", '.User::tableName().'.middle_name)'
            ])->andFilterWhere([
                'role' => $role,
                'status' => $status
            ])->orderBy(['fullName' => SORT_ASC])->asArray()->all(),
            'id',
            'fullName'
        );

        return $clients;
    }

    public function getFullName()
    {
        return $this->last_name . " " . $this->first_name . " " . $this->middle_name;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getToken()
    {
        return base64_encode('xtarantulz-seotm');
    }

    static function canAction($get, $action)
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            if ($user->getId() == 1) return true;

            if ($user->role == User::ROLE_ADMIN) {
                switch ($action) {
                    case ($action == 'index' || $action == 'create' || $action == 'selected'):
                        return true;
                        break;

                    case ($action == 'update' || $action == 'delete' || $action == 'status'):
                        return $get['id'] == $user->getId();
                        break;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
