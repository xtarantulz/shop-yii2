<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset', 'token' => $user->password_reset_token]);
?>

Привіт <?= $user->fullName; ?>,

Перейдіть по посиланню нижче, щоб скинути пароль:

<?= $resetLink ?>
