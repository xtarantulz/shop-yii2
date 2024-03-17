<?php
/**
 * @var string $content
 * @var yii\web\View $this
 * @var common\models\Config $config
 */

use common\models\Config;
use newerton\fancybox\FancyBox;
use yii\bootstrap\Modal;

frontend\assets\FrontendAsset::register($this);

$config = Config::findOne(1);
global $config;
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <?= $this->render('head'); ?>
</head>

<body>
<?php $this->beginBody(); ?>

<?= $this->render('header'); ?>

<?= FancyBox::widget([
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
]); ?>

<?php Modal::begin([
    'header' => '<h2></h2>',
    'id' => 'modal',
    'size' => Modal::SIZE_DEFAULT,
    'footer' => '<button type="button" class="btn btn-danger" data-dismiss="modal">' . Yii::t("app", "Закрити") . '</button>'
]);?>
<div id='modal-content'><?= Yii::t('app', 'Загрузка...'); ?></div>
<?php Modal::end(); ?>

<main id="main">
    <?= $this->render(
        'content',
        ['content' => $content]
    ) ?>
</main>

<?= $this->render('footer'); ?>

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<div id="preloader"></div>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
