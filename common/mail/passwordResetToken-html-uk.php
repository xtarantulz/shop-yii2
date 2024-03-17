<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Привіт <?= $user->fullName; ?>,</p>

    <p>Перейдіть по посиланню нижче, щоб скинути пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
