<?php
/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $products array */
/* @var $clients array */
/* @var $orderItems common\models\OrderItem[] */

$this->title = Yii::t('app', 'Редагування замовлення: {id}', [
    'id' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index', 'OrderSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>

<div class="order-update">
    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
        'clients' => $clients,
        'orderItems' => $orderItems,
    ]) ?>
</div>
