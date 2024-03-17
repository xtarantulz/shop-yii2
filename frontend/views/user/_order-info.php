<?php

use common\models\core\Functional;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $products array */

$total = 0;
?>

<div class="user-order-info">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'ID'); ?></th>
                <th class="text-center" style="width: 80px;"><?= Yii::t('app', 'Зображення'); ?></th>
                <th><?= Yii::t('app', 'Товар'); ?></th>
                <th><?= Yii::t('app', 'Категорія'); ?></th>
                <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Кількість'); ?></th>
                <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Цена'); ?></th>
                <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Сума'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $item): ?>
                <tr>
                    <td class="text-center"><?= $item['product_id']; ?></td>
                    <td class="text-center"><?= Html::a(Html::img(Functional::getMiniImage($item['product_image']), [
                            'style' => 'width:80px;'
                        ]), $item['product_image'], [
                            'rel' => 'fancybox',
                        ]); ?>
                    </td>
                    <td>
                        <?= Html::a($item['product_name'], Url::to(['product/index', 'ProductSearch[id]' => $item['product_id']]), [
                            'target' => '_blank'
                        ]); ?>
                    </td>
                    <td>
                        <?= Html::a($item['category_name'], Url::to(['category/index', 'CategorySearch[id]' => $item['category_id']]), [
                            'target' => '_blank'
                        ]); ?>
                    </td>
                    <td class="text-center">
                        <?= $item['order_count']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['product_price']; ?>
                    </td>
                    <td class="text-center">
                        <?php $total = $total + $item['order_count'] * $item['product_price']; ?>
                        <?= Functional::floorDecimal($item['order_count'] * $item['product_price'], 2); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5"></td>
                <td colspan="2">
                    <b><?= Yii::t('app', 'Разом'); ?>:</b>&nbsp;<?= Functional::floorDecimal($total, 2); ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
