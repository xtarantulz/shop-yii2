<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\core\Functional;

/* @var $this yii\web\View */
/* @var $categories common\models\Category[] */

$this->title = Yii::$app->name;
?>

<div class="site-index">
    <div class="goto-map-section">
        <div class="container">
            <h1 class="goto-map-title">
                <?= Yii::t('app', Yii::$app->config->h1_main_page); ?>
            </h1>

            <?= Html::a('
                <svg>
                    <rect x="0" y="0" fill="none" width="100%" height="100%"></rect>
                </svg>
                ' . Yii::t('app', 'Перейти'),
                Url::to(['page/pro-nas']), [
                    'class' => 'goto-map-btn'
                ]
            ); ?>
        </div>
    </div>

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach (explode(', ', Yii::$app->config->slider_main_page) as $key => $value): ?>
                <?php $class = ''; ?>
                <?php if ($key == 0) $class = 'active'; ?>
                <div class="item <?= $class ?>">
                    <a rel="fancybox" href="<?= $value; ?>" style="background-image: url(<?= $value; ?>)">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-catalog-section">
        <div class="container">
            <h2 class="h2-home"><?= Yii::t('app', 'Каталог'); ?></h2>
            <div class="items row text-center">
                <?php foreach ($categories as $category): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <?= Html::a("<div class='img-wrap'></div>
                            <div class='fa-wrap' style='background-image: url(" . Functional::getMiniImage($category->image) . ")'></div>
                            <p>" . $category->name . "</p>",
                            $category->url);
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
