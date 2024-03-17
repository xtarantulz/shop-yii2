<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/confirm', 'token' => $user->password_reset_token]);
?>

Привіт <?= $user->fullName ?>,

Твій доступ:
E-mail: <?= $user->email; ?>
Пароль: <?= $user->password; ?>

Перейдіть по посиланню нижче, щоб підтвердити свій аккаунт:

<?= $confirmLink ?>