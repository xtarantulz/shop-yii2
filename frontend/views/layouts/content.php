<?php

use common\widgets\Alert;

/* @var $content string */

$class = '';
if (Yii::$app->controller->route != 'site/index') $class = 'container'
?>

<div class="container">
    <?= Alert::widget(); ?>
</div>

<section class="content <?= $class; ?>">
    <?= $content ?>
</section>


