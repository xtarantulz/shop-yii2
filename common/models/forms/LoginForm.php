<?php
namespace common\models\forms;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Електронна пошта'),
            'password' => 'Пароль',
            'rememberMe' => Yii::t('app', 'Пам\'ятай мене'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Неправильна адреса електронної пошти або пароль.'));
            }
        }
    }

    /**
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);

            if($this->_user){
                if(Yii::$app->id == 'app-backend'){
                    if($this->_user->role != User::ROLE_ADMIN && $this->_user->role != User::ROLE_MANAGER){
                        $this->_user = null;
                    }
                }

                if(Yii::$app->id == 'app-frontend'){
                    if($this->_user->role != User::ROLE_CLIENT){
                        $this->_user = null;
                    }
                }
            }
        }

        return $this->_user;
    }
}
