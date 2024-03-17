<?php

namespace common\models;

use common\models\query\FieldQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "field".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $options
 * @property string $prefix
 * @property string $suffix
 * @property string $description
 * @property int $number_after_point
 * @property string $expansions
 *
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $fileExpansions
 * @property string $imageExpansions
 *
 * @property CategoryField[] $categoryFields
 * @property ProductField[] $productFields
 */
class Field extends ActiveRecord
{
    const TYPE_TEXT = 'text';
    const TYPE_BIG_TEXT = 'big_text';
    const TYPE_SELECTION = 'selection';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';
    const TYPE_DATE = 'date';

    const BOOLEAN_NO = 'no';
    const BOOLEAN_YES = 'yes';

    const EXPANSION_PDF = 'pdf';
    const EXPANSION_TXT = 'txt';
    const EXPANSION_JPG = 'jpg';
    const EXPANSION_JPEG = 'jpeg';
    const EXPANSION_PNG = 'png';
    const EXPANSION_BMP = 'bmp';

    /**
     * @param $name string
     * @return array
     */
    public static function getLabels($name)
    {
        $labels = [
            'boolean' => [
                self::BOOLEAN_NO => Yii::t('app', 'Hі'),
                self::BOOLEAN_YES => Yii::t('app', 'Так'),
            ],
            'type' => [
                self::TYPE_TEXT => Yii::t('app', 'Текст'),
                self::TYPE_BIG_TEXT => Yii::t('app', 'Великий текст'),
                self::TYPE_SELECTION => Yii::t('app', 'Вибор'),
                self::TYPE_INTEGER => Yii::t('app', 'Ціле число'),
                self::TYPE_FLOAT => Yii::t('app', 'Число з рухомою комою'),
                self::TYPE_BOOLEAN => Yii::t('app', 'Так || Ні'),
                self::TYPE_FILE => Yii::t('app', 'Файл'),
                self::TYPE_IMAGE => Yii::t('app', 'Зображення'),
                self::TYPE_DATE => Yii::t('app', 'Дата'),
            ],
            'expansions' => [
                'txt' => 'txt',
                'pdf' => 'pdf',
                'doc' => 'doc',
                'docx' => 'docx',
                'xls' => 'xls',
                'xlsx' => 'xlsx',
                'jpg' => 'jpg',
                'jpeg' => 'jpeg',
                'png' => 'png',
            ],
            'fileExpansions' => [
                'txt' => 'txt',
                'pdf' => 'pdf',
                'doc' => 'doc',
                'docx' => 'docx',
                'xls' => 'xls',
                'xlsx' => 'xlsx'
            ],
            'imageExpansions' => [
                'jpg' => 'jpg',
                'jpeg' => 'jpeg',
                'png' => 'png',
            ],
        ];

        return $labels[$name];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['description', 'expansions'], 'string'],
            [['options'], 'safe'],
            [['number_after_point', 'created_at', 'updated_at'], 'integer'],
            [['name', 'type', 'prefix', 'suffix'], 'string', 'max' => 255],

            ['type', 'in', 'range' => [self::TYPE_TEXT, self::TYPE_BIG_TEXT, self::TYPE_SELECTION, self::TYPE_INTEGER, self::TYPE_FLOAT, self::TYPE_BOOLEAN, self::TYPE_FILE, self::TYPE_IMAGE, self::TYPE_DATE]],
            [['fileExpansions', 'imageExpansions'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Ім\'я'),
            'type' => Yii::t('app', 'Тип'),
            'options' => Yii::t('app', 'Варіанти'),
            'prefix' => Yii::t('app', 'Префікс'),
            'suffix' => Yii::t('app', 'Суфікс'),
            'description' => Yii::t('app', 'Опис'),
            'number_after_point' => Yii::t('app', 'Кількість цифр после коми'),
            'expansions' => Yii::t('app', 'Розширення'),

            'created_at' => Yii::t('app', 'Створено'),
            'updated_at' => Yii::t('app', 'Оновлено'),

            'fileExpansions' => Yii::t('app', 'Можливі розширення файла'),
            'imageExpansions' => Yii::t('app', 'Можливі розширення зображення'),
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
     * {@inheritdoc}
     */
    public function setFileExpansions($value)
    {
        if ($this->type == self::TYPE_FILE){
            if(is_array($value) && count($value)){
                $value = array_diff($value, array(''));

                $this->fileExpansions = $value;
                $this->expansions = Json::encode($this->fileExpansions);
            }else{
                $this->expansions = null;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFileExpansions()
    {
        if ($this->type == self::TYPE_FILE) {
            return $this->expansions;
        }else{
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setImageExpansions($value)
    {
        if ($this->type == self::TYPE_IMAGE){
            if(is_array($value) && count($value)){
                $value = array_diff($value, array(''));

                $this->imageExpansions = $value;
                $this->expansions = Json::encode($this->imageExpansions);
            }else{
                $this->expansions = null;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImageExpansions()
    {
        if ($this->type == self::TYPE_IMAGE) {
            return $this->expansions;
        }else{
            return null;
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryFields()
    {
        return $this->hasMany(CategoryField::className(), ['field_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductFields()
    {
        return $this->hasMany(ProductField::className(), ['field_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->options = Json::decode($this->options);
        $this->expansions = Json::decode($this->expansions);
    }

    /**
     * {@inheritdoc}
     * @return FieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FieldQuery(get_called_class());
    }
}
