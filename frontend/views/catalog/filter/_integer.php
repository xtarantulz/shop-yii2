<?php
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field array */
/* @var $model common\models\forms\FilterForm */

$label_from = Yii::t('app', 'від');
$label_to = Yii::t('app', 'до');
if($field['prefix']){
    $label_from = $label_from." (".$field['prefix'].")";
    $label_to = $label_to." (".$field['prefix'].")";
}elseif($field['suffix']){
    $label_from = $label_from." (".$field['suffix'].")";
    $label_to = $label_to." (".$field['suffix'].")";
}
?>

<fieldset>
    <legend><?= $field['name']; ?></legend>
    <div class="row">
        <div class="col-xs-6 col">
            <?= $form->field($model, 'from[' . $field['id'] . ']')->widget(TouchSpin::classname(), [
                'pluginOptions' => [
                    'min' => 0,
                    'decimals' => 0,
                    'verticalbuttons' => true
                ],
                'options' => [
                    'value' => $model->from
                ],
            ])->label($label_from); ?>
        </div>
        <div class="col-xs-6 col">
            <?= $form->field($model, 'to[' . $field['id'] . ']')->widget(TouchSpin::classname(), [
                'pluginOptions' => [
                    'min' => 0,
                    'decimals' => 0,
                    'verticalbuttons' => true
                ],
                'options' => [
                    'value' => $model->to
                ],
            ])->label($label_to); ?>
        </div>
    </div>
</fieldset>

