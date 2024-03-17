<?php
use yii\helpers\Html;

/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/confirm', 'token' => $user->password_reset_token]);
?>
<div class="user-confirm">
    <p>Привіт <?= $user->fullName ?>,</p>

    <p>
        Твій доступ:<br>
        E-mail: <?= $user->email; ?><br>
        Пароль: <?= $user->password; ?><br>
    </p>

    <p>Перейдіть по посиланню нижче, щоб підтвердити свій аккаунт:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>