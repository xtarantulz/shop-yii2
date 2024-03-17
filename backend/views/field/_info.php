<?php

use common\models\Field;

/* @var $this yii\web\View */
/* @var $model common\models\Field */
?>

<div class="field-info">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td width="50%"><b><?= Yii::t('app', 'Властивість'); ?></b></td>
            <td width="50%"><b><?= Yii::t('app', 'Значення'); ?></b></td>
        </tr>
        </thead>

        <tbody>
        <?php if ($model->name): ?>
            <tr>
                <td><?= $model->attributeLabels()['name']; ?></td>
                <td><?= $model->name; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->type): ?>
            <tr>
                <td><?= $model->attributeLabels()['type']; ?></td>
                <td><?= Field::getLabels('type')[$model->type]; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->options): ?>
            <tr>
                <td><?= $model->attributeLabels()['options']; ?></td>
                <td><?= implode(', ', $model->options); ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->expansions): ?>
            <tr>
                <td><?= $model->attributeLabels()['expansions']; ?></td>
                <td><?= implode(', ', $model->expansions); ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->number_after_point): ?>
            <tr>
                <td><?= $model->attributeLabels()['number_after_point']; ?></td>
                <td><?= $model->number_after_point; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->prefix): ?>
            <tr>
                <td><?= $model->attributeLabels()['prefix']; ?></td>
                <td><?= $model->prefix; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->suffix): ?>
            <tr>
                <td><?= $model->attributeLabels()['suffix']; ?></td>
                <td><?= $model->suffix; ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->updated_at): ?>
            <tr>
                <td><?= $model->attributeLabels()['updated_at']; ?></td>
                <td><?= Yii::$app->formatter->asDatetime($model->updated_at); ?></td>
            </tr>
        <?php endif; ?>

        <?php if ($model->created_at): ?>
            <tr>
                <td><?= $model->attributeLabels()['created_at']; ?></td>
                <td><?= Yii::$app->formatter->asDatetime($model->created_at); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
