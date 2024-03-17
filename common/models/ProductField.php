<?php

namespace common\models;

use common\models\query\ProductFieldQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\image\drivers\Image;

/**
 * This is the model class for table "product_field".
 *
 * @property int $id
 * @property int $product_id
 * @property int $field_id
 * @property string $value
 * @property int $updated_at
 * @property int $created_at
 *
 * @property Product $product
 * @property Field $field
 */
class ProductField extends ActiveRecord
{
    public $image_upload;
    public $file_upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'field_id', 'value'], 'required'],
            [['product_id', 'field_id', 'updated_at', 'created_at'], 'integer'],
            ['value', 'safe'],
            //[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            //[['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],

            [['image_upload'], 'image', 'skipOnEmpty' => true],
            [['file_upload'], 'file', 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Товар'),
            'field_id' => Yii::t('app', 'Поле'),
            'value' => Yii::t('app', 'Значення'),
            'updated_at' => Yii::t('app', 'Оновлено'),
            'created_at' => Yii::t('app', 'Створено'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }

    static function getModel($product_id, $field_id)
    {
        $productField = null;
        if ($product_id) {
            $productField = ProductField::findOne([
                'product_id' => $product_id,
                'field_id' => $field_id
            ]);
        }

        if (!$productField) {
            $productField = new ProductField();
            $productField->product_id = $product_id;
            $productField->field_id = $field_id;
        }

        return $productField;
    }

    function uploadFile()
    {
        //загрузка файла
        $field = Field::findOne($this->field_id);
        if ($field->type == Field::TYPE_IMAGE || $field->type == Field::TYPE_FILE) {
            $value = 'image_upload';
            if ($field->type == Field::TYPE_FILE) $value = 'file_upload';
            $dir = '/upload/productfield/' . $this->field_id . "/" . $this->product->category_id;
            BaseFileHelper::createDirectory(Yii::getAlias('@frontend/web') . $dir);

            $name = "/" . time() . $_FILES['ProductField']['name'][$value][$this->field_id];
            if (move_uploaded_file($_FILES['ProductField']['tmp_name'][$value][$this->field_id], Yii::getAlias('@frontend/web') . $dir . $name)) {
                $this->value = $dir . $name;

                if ($field->type == Field::TYPE_IMAGE) {
                    //создание миниатюры
                    BaseFileHelper::createDirectory(Yii::getAlias('@frontend/web') . $dir . "/mini");
                    if (!file_exists(Yii::getAlias('@frontend/web') . $dir . "/mini" . $name)) {
                        if (file_exists(Yii::getAlias('@frontend/web') . $dir . $name)) {
                            $image = Yii::$app->image->load(Yii::getAlias('@frontend/web') . $dir . $name);
                            $image->resize(400, NULL, Image::WIDTH, 100);
                            $image->save(Yii::getAlias('@frontend/web') . $dir . "/mini" . $name, 100);
                        }
                    }
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     * @return ProductFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductFieldQuery(get_called_class());
    }
}
