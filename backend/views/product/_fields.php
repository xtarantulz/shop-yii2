<?php

use common\models\Field;
use yii\bootstrap\ActiveForm;
use common\models\ProductField;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $fields common\models\Field[] */
/* @var $category_id integer */
/* @var $product_id integer */
/* @var $form_action string */

$form = ActiveForm::begin([
    'id' => 'form-product-fields',
    'action' => $form_action,
    'options' => ['enctype' => 'multipart/form-data']
]);

$fields = Field::find()->joinWith('categoryFields')->where([
    'category_field.category_id' => $category_id
])->all();
?>

<?php foreach ($fields as $field): ?>
    <?php $model = ProductField::getModel($product_id, $field->id);  ?>

    <?php echo $this->render('field/_'.$field->type, [
        'model' => $model,
        'form' => $form,
        'field' => $field
    ]);?>
<?php endforeach; ?>

<?php ActiveForm::end(); ?>