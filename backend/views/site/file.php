<?php

use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Файловий менеджер');
?>

<div class="file-index">
    <?= ElFinder::widget([
        'language' => Yii::$app->language,
        'controller' => 'elfinder',
        'path' => '',
        'frameOptions' => [
            'style' => 'width: 95%; height: 500px; border: 0;'
        ]
    ]); ?>
</div>
