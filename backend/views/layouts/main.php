<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use newerton\fancybox\FancyBox;

yiister\gentelella\assets\Asset::register($this);
backend\assets\BackendAsset::register($this);


//для картинок
echo FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);

if (Yii::$app->user->isGuest) {
    simialbi\yii2\animatecss\AnimateCssPluginAsset::register($this);

    echo $this->render(
        'guest',
        ['content' => $content]
    );
} else {
    $user = Yii::$app->user->identity;

    ?>
    <?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('head.php'); ?>
    </head>

    <body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
    <?php $this->beginBody(); ?>

    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?= $this->render('left', [
                    'user' => $user
                ]); ?>
            </div>

            <div class="top_nav">
                <?= $this->render('header', [
                    'user' => $user
                ]); ?>
            </div>

            <div class="right_col" role="main">
                <?= $this->render(
                    'content',
                    ['content' => $content]
                ) ?>
            </div>

            <footer>
                <div class="text-center">
                    <?= $this->render('/blocks/_copyright'); ?>
                </div>
            </footer>
        </div>
    </div>

    <?php $this->endBody(); ?>
    </body>
    </html>
    <?php $this->endPage(); ?>
<?php } ?>