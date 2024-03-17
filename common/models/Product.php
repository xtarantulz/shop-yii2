<?php

namespace common\models;

use common\behaviors\FileBehavior;
use common\models\core\Functional;
use common\models\query\CategoryQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $images
 * @property integer $category_id
 * @property double $price
 * @property string $description
 *
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 *
 * @property string $slug
 *
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
 * @property CategoryField[] $categoryFields
 * @property ProductField[] $productFields
 * @property Field[] $fields
 * @property OrderItem[] $orderItems
 *
 * @property string $url
 *
 */
class Product extends ActiveRecord
{
    public $image_upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'description', 'price'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['category_id'], 'integer'],
            [['name', 'slug', 'image'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['description', 'images'], 'safe'],

            [['seo_title'], 'string', 'max' => 255],
            [['seo_keywords', 'seo_description'], 'safe'],

            [['price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/', 'max' => 9999999.99],
            [['price'], 'filter', 'filter' => function ($value) {
                $value = Functional::floorDecimal(1 * str_replace(',', '.', $value), 2);
                return $value;
            }],

            [['image_upload'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, bmp'],

            //[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Назва'),
            'image_upload' => Yii::t('app', 'Зображення'),
            'image' => Yii::t('app', 'Зображення'),
            'images' => Yii::t('app', 'Галерея'),
            'price' => Yii::t('app', 'Цена'),
            'category_id' => Yii::t('app', 'Категорія'),
            'description' => Yii::t('app', 'Опис'),

            'seo_title' => Yii::t('app', 'SEO заголовок'),
            'seo_keywords' => Yii::t('app', 'SEO ключові слова'),
            'seo_description' => Yii::t('app', 'SEO опис'),

            'slug' => Yii::t('app', 'Посилання'),

            'created_at' => Yii::t('app', 'Створена'),
            'updated_at' => Yii::t('app', 'Оновлена'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => FileBehavior::className(),
                'options' => [
                    'image_upload' => [
                        'name' => 'image',
                        'type' => 'image',
                        'width' => 200,
                        'height' => 200
                    ],
                ]
            ],
        ];
    }

    public function afterFind()
    {
        if (!$this->image) $this->image = '/img/no_image.png';

        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //урл
            $this->slug = Functional::translite($this->name);

            return parent::beforeSave($insert);
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    static function getAllNames(){
        $products = ArrayHelper::map(
            Product::find()->select([
                'id', 'name'
            ])->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            'name'
        );

        return $products;
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryFields()
    {
        return $this->hasMany(CategoryField::className(), ['category_id' => 'category_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getProductFields()
    {
        return $this->hasMany(ProductField::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id' => 'field_id'])->via('productFields');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::to([$this->category->alias . "/" . $this->slug . ".html"]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
