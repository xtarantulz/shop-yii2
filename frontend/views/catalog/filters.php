<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $fields array */
/* @var $search common\models\ProductField[] */
/* @var $model common\models\Category */

?>

<div class="category-filters">
    <h2><?= Yii::t('app', 'Фільтри'); ?></h2>
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>

    <?php foreach ($fields as $field): ?>
        <?php if ($field['filter']): ?>
            <?= $this->render('filter/_' . $field['type'], [
                'form' => $form,
                'model' => $search[$field['id']],
                'field' => $field,
            ]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <br>
    <?= Html::resetButton(Yii::t('app', 'Очистити'), ['class' => 'btn btn-warning pull-left text-uppercase']); ?>
    <?= Html::submitButton(Yii::t('app', 'Найти'), ['class' => 'btn btn-success pull-right text-uppercase']); ?>
    <div class="clearfix"></div>

    <?php ActiveForm::end(); ?>
</div>
