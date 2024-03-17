<?php

namespace common\models;

use common\models\query\CategoryFieldQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_field".
 *
 * @property int $id
 * @property int $category_id
 * @property int $field_id
 * @property int $depth
 * @property int $filter
 * @property int $list
 * @property int $updated_at
 * @property int $created_at
 *
 * @property Category $category
 * @property Field $field
 */
class CategoryField extends ActiveRecord
{
    const FILTER_DISABLED = 0;
    const FILTER_ENABLED = 1;

    const SHOW_NO = 0;
    const SHOW_YES = 1;

    /**
     * @param $name string
     * @return array
     */
    public static function getLabels($name)
    {
        $labels = [
            'filter' => [
                self::FILTER_DISABLED => Yii::t('app', 'Ні'),
                self::FILTER_ENABLED => Yii::t('app', 'Так'),
            ],
            'list' => [
                self::SHOW_NO => Yii::t('app', 'Ні'),
                self::SHOW_YES => Yii::t('app', 'Так'),
            ]
        ];

        return $labels[$name];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'field_id', 'filter', 'list'], 'required'],
            [['category_id', 'field_id', 'depth', 'filter', 'list', 'updated_at', 'created_at'], 'integer'],
            //[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            //[['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],

            ['filter', 'in', 'range' => [self::FILTER_DISABLED, self::FILTER_ENABLED]],
            ['list', 'in', 'range' => [self::SHOW_NO, self::SHOW_YES]],

            ['depth', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Категорія'),
            'field_id' => Yii::t('app', 'Поле'),
            'depth' => Yii::t('app', 'Вага'),
            'filter' => Yii::t('app', 'Фільтрувати?'),
            'list' => Yii::t('app', 'Показувати в списку?'),
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
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryFieldQuery(get_called_class());
    }
}
