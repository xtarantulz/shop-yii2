<?php

use yii\helpers\Html;
use yii\web\View;
use backend\assets\CategoryTreeAsset;

/**
 * @var $this View
 * @var $id integer
 * @var $formName string
 * @var $categories common\models\Category[]
 */

$this->registerJs("var selectedCategoryId = $id;", View::POS_BEGIN);
CategoryTreeAsset::register($this);

$this->title = 'Категорії';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken, ['id' => Yii::$app->request->csrfParam]) ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a('Створити Категорію', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Перегляд Таблиці', ['list'], ['class' => 'btn btn-primary pull-right']) ?>
            </p>

            <div class="tree" id="treeViewCategory" data-form-name="<?= $formName ?>">
                <?php if (count($categories)): ?>
                    <ol class="category-list">
                        <?php foreach ($categories as $category): ?>
                            <?= $this->render('_item', [
                                'category' => $category
                            ]) ?>
                        <?php endforeach; ?>
                    </ol>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
