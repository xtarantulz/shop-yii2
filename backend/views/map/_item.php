<?php

/**
 * @var $this yii\web\View
 * @var $map common\models\Map
 */

use yii\helpers\Html;
use yii\helpers\Url;

$hasChildren = isset($map['children']);
?>

<li class="category-list-item"
    data-id="<?= $map['id'] ?>"
    data-sort="<?= $map['sort_order'] ?>"
    data-update-url="<?= Url::to(['update', 'id' => $map['id']]) ?>">

    <div>
        <a class="btn btn-xs btn-primary drag-btn" title="<?= Yii::t('app', 'Перемістити'); ?>">
            <i class="fa fa-arrows"></i>
        </a>

        <span><i class="icon-folder-open"></i><?= $map['name'] ?></span>

        <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $map['id']], [
            'class' => 'btn btn-xs btn-primary',
            'title' => Yii::t('app', 'Редагувати')
        ]) ?>

        <?= Html::a('<i class="fa fa-plus"></i>', ['create', 'parent_id' => $map['id']], [
            'class' => 'btn btn-xs btn-success',
            'title' => Yii::t('app', 'Добавити під-меню')
        ]) ?>

        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $map['id']], [
            'data' => ['confirm' => Yii::t('app', 'Ви впевнені, що хочете видалити цей елемент?'), 'method' => 'post',],
            'class' => 'btn btn-xs btn-danger',
            'title' => Yii::t('app', 'Видалити')
        ]) ?>

        <a href="#categoryList<?= $map['id'] ?>"
           class="btn btn-xs btn-primary collapse-list-btn <?= $hasChildren ? '' : 'disabled' ?>"
           role="button"
           data-toggle="collapse"
           aria-expanded="false" aria-controls="categoryList<?= $map['id'] ?>">
            <i class="fa <?= $hasChildren ? 'fa-arrow-up' : 'fa-arrow-down' ?>"></i>
        </a>
    </div>

    <ol id="categoryList<?= $map['id'] ?>" class="collapse category-list <?= $hasChildren ? 'in' : '' ?>">
        <?php if ($hasChildren): ?>
            <?php foreach ($map['children'] as $child): ?>
                <?= $this->render('_item', [
                    'map' => $child
                ]) ?>
            <?php endforeach; ?>
        <?php endif ?>
    </ol>
</li>
