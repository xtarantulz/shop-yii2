<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\query\ConfigQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $h1_main_page
 * @property string $slider_main_page
 * @property string $footer_description
 * @property int $updated_at
 * @property int $created_at
 */
class Config extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'address', 'city', 'region', 'country', 'h1_main_page', 'slider_main_page', 'footer_description'], 'required'],
            [['slider_main_page', 'footer_description'], 'string'],
            [['updated_at', 'created_at'], 'integer'],
            [['email', 'phone', 'address', 'city', 'region', 'country', 'h1_main_page'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Телефон'),
            'address' => Yii::t('app', 'Адреса'),
            'city' => Yii::t('app', 'Місто'),
            'region' => Yii::t('app', 'Район'),
            'country' => Yii::t('app', 'Країна'),
            'h1_main_page' => Yii::t('app', 'Заголовок на головній сторінці'),
            'slider_main_page' => Yii::t('app', 'Фото слайдера на головній сторінці'),
            'footer_description' => Yii::t('app', 'Підвал описання'),
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
     * {@inheritdoc}
     * @return ConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigQuery(get_called_class());
    }
}
