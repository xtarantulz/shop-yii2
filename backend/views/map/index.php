<?php

use yii\helpers\Html;
use yii\web\View;
use backend\assets\CategoryTreeAsset;

/**
 * @var $this View
 * @var $id integer
 * @var $formName string
 * @var $maps common\models\Map[]
 */

$this->registerJs("var selectedCategoryId = $id;", View::POS_BEGIN);
CategoryTreeAsset::register($this);

$this->title = 'Пункти Меню';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="map-index">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken, ['id' => Yii::$app->request->csrfParam]) ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a('Створити Пункт Меню', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Перегляд Таблиці', ['list'], ['class' => 'btn btn-primary pull-right']) ?>
            </p>

            <div class="tree" id="treeViewCategory" data-form-name="<?= $formName ?>">
                <?php if (count($maps)): ?>
                    <ol class="category-list">
                        <?php foreach ($maps as $map): ?>
                            <?= $this->render('_item', [
                                'map' => $map
                            ]) ?>
                        <?php endforeach; ?>
                    </ol>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
