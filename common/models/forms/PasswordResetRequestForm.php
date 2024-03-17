<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Yii::t('app', 'Користувача з такою адресою електронної пошти не існує.')
            ],
        ];
    }

    /**
     * @return boolean
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html-'.Yii::$app->language, 'text' => 'passwordResetToken-text-'.Yii::$app->language],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->config->email => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Відновлення пароля для ') . Yii::$app->name)
            ->send();
    }
}
