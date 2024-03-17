<?php

use common\models\Field;
use common\models\CategoryField;

/* @var $this yii\web\View */
/* @var $fields array */

?>

<div class="category-info">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td width="50%"><b><?= Yii::t('app', 'Поле'); ?></b></td>
            <td width="25%"><b><?= Yii::t('app', 'Тип'); ?></b></td>
            <td width="25%"><b><?= Yii::t('app', 'Фільтрувати?'); ?></b></td>
            <td width="25%"><b><?= Yii::t('app', 'Показувати в списку?'); ?></b></td>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($fields as $field): ?>
            <tr>
                <td><?= $field['name']; ?></td>
                <td><?= Field::getLabels('type')[$field['type']]; ?></td>
                <td><?= CategoryField::getLabels('filter')[$field['filter']]; ?></td>
                <td><?= CategoryField::getLabels('list')[$field['list']]; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
