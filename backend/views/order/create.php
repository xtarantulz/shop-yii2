<?php
/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $products array */
/* @var $clients array */
/* @var $orderItems common\models\OrderItem[] */

$this->title = Yii::t('app', 'Створення замовлення');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-create">
    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
        'clients' => $clients,
        'orderItems' => $orderItems,
    ]) ?>
</div>
