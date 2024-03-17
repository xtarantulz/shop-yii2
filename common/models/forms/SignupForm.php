<?php
namespace common\models\forms;

use yii;
use yii\base\Model;
use common\models\User;

class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $middle_name;
    public $phone;
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name', 'phone', 'email'], 'trim'],
            [['first_name', 'last_name', 'middle_name', 'phone', 'email', 'password'], 'required'],
            [['first_name', 'last_name', 'middle_name', 'phone', 'email'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Ця електронна адреса вже існуе')],
            ['password', 'string', 'min' => 6],
            [['phone'], 'validatePhone'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('app', 'Ім\'я'),
            'last_name' => Yii::t('app', 'Прізвище'),
            'middle_name' => Yii::t('app', 'По батькові'),
            'email' => Yii::t('app', 'Електронна пошта'),
            'password' => 'Пароль',
            'phone' => Yii::t('app', 'Телефон'),
        ];
    }

    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            //уберем маску
            $this->phone = str_replace('-', '', $this->phone);
            $this->phone = str_replace('(', '', $this->phone);
            $this->phone = str_replace(')', '', $this->phone);
            $this->phone = str_replace(' ', '', $this->phone);
            $this->phone = str_replace('+380', '', $this->phone);
            if (!preg_match("/^[\d]+$/", $this->phone) || strlen($this->phone) != 9) {
                $this->addError($attribute, Yii::t('app', 'Некоретний телефон'));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->middle_name = $this->middle_name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->password_reset_token = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_DELETED;
        $user->role = User::ROLE_CLIENT;
        $user->setPassword($this->password);
        $user->password = $this->password;

        return $user->save() ? $user : null;
    }

    /**
     * {@inheritdoc}
     */
    public function sentEmailConfirm(User $user)
    {
        $sent = Yii::$app->mailer
            ->compose(
                ['html' => 'userSignupConfirm-html-'.Yii::$app->language, 'text' => 'userSignupConfirm-text-'.Yii::$app->language],
                ['user' => $user])
            ->setTo($user->email)
            ->setFrom([Yii::$app->config->email => Yii::$app->name])
            ->setSubject(Yii::t('app', 'Підтвердження реєстрації'))
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Помилка відправки.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function confirmation($token)
    {
        if (empty($token)) {
            throw new \DomainException(Yii::t('app', 'Порожній токен підтвердження.'));
        }

        $user = User::findOne(['password_reset_token' => $token]);
        if (!$user) {
            throw new \DomainException(Yii::t('app', 'Користувач не знайдений.'));
        }

        $user->password_reset_token = null;
        $user->status = User::STATUS_ACTIVE;
        if (!($user->validate() && $user->save())) {
            throw new \RuntimeException(Yii::t('app', 'Збереження помилки.'));
        }

        if (!Yii::$app->getUser()->login($user)){
            throw new \RuntimeException(Yii::t('app', 'Помилка аутентифікації.'));
        }
    }
}
