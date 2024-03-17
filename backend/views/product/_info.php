<?php

use common\models\Field;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $fields array */
?>

<div class="product-info">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td width="50%"><b><?= Yii::t('app', 'Поле'); ?></b></td>
            <td width="25%"><b><?= Yii::t('app', 'Тип'); ?></b></td>
            <td width="25%"><b><?= Yii::t('app', 'Значення'); ?></b></td>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($fields as $field): ?>
            <tr>
                <td><?= $field['name']; ?></td>
                <td><?= Field::getLabels('type')[$field['type']]; ?></td>
                <td>
                    <?php
                    switch ($field['type']) {
                        case Field::TYPE_IMAGE:
                            echo Html::a(Html::img($field['value'], [
                                'style' => 'height: 40px;'
                            ]), $field['value'], [
                                'target' => '_blank',
                            ]);
                            break;
                        case Field::TYPE_FILE:
                            echo Html::a(Yii::t('app', 'скачати'), $field['value'], [
                                'download' => true
                            ]);
                            break;
                        case Field::TYPE_BOOLEAN:
                            echo Field::getLabels('boolean')[$field['value']];
                            break;

                        case ($field['type'] == Field::TYPE_INTEGER || $field['type'] == Field::TYPE_FLOAT):
                            if ($field['prefix']) echo $field['prefix'];
                            echo $field['value'];
                            if ($field['suffix']) echo $field['suffix'];
                            break;
                        default:
                            echo $field['value'];
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
