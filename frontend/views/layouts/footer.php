<?php

use common\models\Map;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $footer_maps Map[] */

$footer_maps = Map::find()->andFilterWhere([
    'is', 'parent_id', new Expression('null')
])->orderBy(['sort_order' => SORT_ASC])->all();

?>

<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 footer-info">
                    <h4><?= Yii::$app->name; ?></h4>
                    <p><?= Yii::$app->config->footer_description; ?></p>
                </div>

                <div class="col-lg-2 col-md-6 footer-links text-center">
                    <h4><?= Yii::t('app', 'Посилання') ?></h4>
                    <ul>
                        <?php foreach ($footer_maps as $key => $map): ?>
                            <li>
                                <?= Html::a($map->name, Url::to([$map->slug])); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-contact text-right">
                    <h4><?= Yii::t('app', 'Зв\'яжіться з нами') ?></h4>
                    <p>
                        <?= Yii::$app->config->address . ", " . Yii::$app->config->city; ?> <br>
                        <?= Yii::$app->config->region; ?> обл., <?= Yii::$app->config->country; ?> <br>
                        <strong><?= Yii::t('app', 'Телефон'); ?>:</strong> <?= Yii::$app->config->phone; ?><br>
                        <strong><?= Yii::t('app', 'Email'); ?>:</strong> <?= Yii::$app->config->email; ?><br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-bottom">
        <div class="copyright">
            &copy; Copyright <strong><?= Yii::$app->name; ?></strong>. Всі права захищені.
        </div>
        <div class="credits">
            Розроблено <a href="mailTo: support.gmail.com">support</a>
        </div>
    </div>
</footer>
