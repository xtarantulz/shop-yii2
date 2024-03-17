<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Field;
use common\models\core\Functional;

/* @var $product array */
/* @var $model common\models\Category */
?>

<div class="fields">
    <h2>
        <a href="<?= Url::to([$model->alias . "/" . $product['slug'] . ".html"]) ?>">
            <?= $product['name']; ?>
        </a>
    </h2>

    <div class="field">
        <a rel="fancybox" href="<?= $product['image']; ?>" class="img-field"
           style="background-image: url(<?= Functional::getMiniImage($product['image']); ?>)"></a>
    </div>

    <?php foreach ($product['fields'] as &$field): ?>
        <?php if ($field['list']): ?>
            <?php if (!isset($field['value'])) $field['value'] = null; ?>
            <?php if ($field['type'] == Field::TYPE_FLOAT || $field['type'] == Field::TYPE_INTEGER) {
                $field['value'] = $field['prefix'] . $field['value'] . $field['suffix'];
            }; ?>

            <div class="field">
                <?php if ($field['type'] != Field::TYPE_BIG_TEXT): ?>
                    <b class="label-field"><?= $field['name']; ?>: </b><br>
                    <span>
                        <?php if ($field['type'] == Field::TYPE_FILE): ?>
                            <?= Html::a(Yii::t('app', 'Завантажити файл'), $field['value'], [
                                'download' => true,
                            ]) ?>
                        <?php elseif ($field['type'] == Field::TYPE_IMAGE): ?>
                            <?= Html::a(Yii::t('app', 'Відкрити зображення'), $field['value'], [
                                'rel' => 'fancybox',
                            ]) ?>
                        <?php else: ?>
                            <?= $field['value']; ?>
                        <?php endif; ?>
                    </span>
                <?php else: ?>
                    <label><?= $field['name']; ?>: </label>
                    <div class="big-text"><?= $field['value']; ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="field price">
        <b class="label-field"><?= Yii::t('app', 'Ціна'); ?>: </b>
        <span><?= $product['price']; ?></span>
    </div>

    <div class="clearfix"></div>
    <?= Html::a(Yii::t('app', 'Купити'), '#', [
        'class' => 'btn btn-success pull-left text-uppercase buy-button',
        'data-id' => $product['id']
    ]); ?>
    <?= Html::a(Yii::t('app', 'Перейти'), Url::to([$model->alias . "/" . $product['slug'] . ".html"]), [
        'class' => 'btn btn-primary pull-right text-uppercase'
    ]); ?>
    <div class="clearfix"></div>
</div>