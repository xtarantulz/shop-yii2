<?php

/* @var $this yii\web\View */
/* @var $order common\models\Order */


$this->title = Yii::t('app', 'Замовлення успішно створено');
?>

<div class="cart-success">
    <h1><?= $this->title; ?></h1>

    <p>
        <?= Yii::t('app', 'Шановний {full_name}. Ваше замовлення за номером {number} успішно створено.', [
            'full_name' => "<b>".$order->fullName."</b>",
            'number' => "<b>".$order->id."</b>"
        ]); ?>
    </p>

    <p>
        <?= Yii::t('app', 'Ми Вам відправили лист з вмістом замовлення на пошту {email}.', [
            'email' => "<b>".$order->email."</b>"
        ]); ?>
    </p>

    <p>
        <?= Yii::t('app', 'Протягом години з Вами зв\'яжеться наш менеджер по номеру телефону {phone} для підтвердження замовлення.', [
            'phone' => "<b>+380".$order->phone."</b>"
        ]); ?>
    </p>
</div>