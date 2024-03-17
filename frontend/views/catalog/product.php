<?php

use common\models\Field;
use yii\helpers\Html;
use common\models\core\Functional;

/* @var $this yii\web\View */
/* @var $product array */

$this->title = $product['name'];
?>

<div class="product-index">
    <br>
    <h1><?= $product['name']; ?> </h1>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#main-div"><?= Yii::t('app', 'Інформація') ?></a></li>
        <li><a data-toggle="tab" href="#fields-div"><?= Yii::t('app', 'Характеристики') ?></a></li>
        <?php if ($product['images']): ?>
            <li><a data-toggle="tab" href="#gallery-div"><?= Yii::t('app', 'Галерея') ?></a></li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">
        <div id="main-div" class="tab-pane fade in active">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a rel="fancybox" href="<?= $product['image']; ?>" class="img-field"
                       style="background-image: url(<?= Functional::getMiniImage($product['image']); ?>)"></a>

                    <p class="price">
                        <b><?= Yii::t('app', 'Ціна'); ?>: </b>
                        <span><?= $product['price']; ?></span>
                    </p>

                    <p>
                        <?= Html::a(Yii::t('app', 'Купити'), '#', [
                            'class' => 'btn btn-success pull-left text-uppercase buy-button',
                            'data-id' => $product['id']
                        ]); ?>
                    </p>

                    <div class="clearfix"></div>
                    <br>
                    <div class="description">
                        <label><?= Yii::t('app', 'Опис'); ?></label>
                        <?= $product['description']; ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="fields-div" class="tab-pane fade">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach ($product['fields'] as &$field): ?>
                        <?php if ($field['type'] == Field::TYPE_FLOAT || $field['type'] == Field::TYPE_INTEGER) {
                            $field['value'] = $field['prefix'] . $field['value'] . $field['suffix'];
                        }; ?>

                        <div class="field">
                            <?php if ($field['type'] != Field::TYPE_BIG_TEXT): ?>
                                <b class="label-field"><?= $field['name']; ?>: </b>
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
                                <p>
                                    <?= $field['value']; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if ($product['images']): ?>
            <div id="gallery-div" class="tab-pane fade">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php foreach (explode(', ', $product['images']) as $key => $value): ?>
                                    <?php $class = ''; ?>
                                    <?php if ($key == 0) $class = 'active'; ?>
                                    <li data-target="#carousel" data-slide-to="<?= $key; ?>" class="<?= $class ?>"></li>
                                <?php endforeach; ?>
                            </ol>

                            <div class="carousel-inner">
                                <?php foreach (explode(', ', $product['images']) as $key => $value): ?>
                                    <?php $class = ''; ?>
                                    <?php if ($key == 0) $class = 'active'; ?>
                                    <div class="item <?= $class ?>">
                                        <a rel="fancybox" href="<?= $value; ?>" style="background-image: url(<?= $value; ?>)">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>