<?php

namespace common\models;

use common\models\core\Functional;
use common\models\query\PageQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 *
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 *
 * @property string $slug
 *
 * @property int $created_at
 * @property int $updated_at
 *
 * @property string $url
 */
class Page extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['content', 'safe'],

            [['slug', 'name'], 'unique'],

            [['seo_title'], 'string', 'max' => 255],
            [['seo_keywords', 'seo_description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
            'content' => Yii::t('app', 'Контент'),

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
            TimestampBehavior::className()
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //урлы на карте сайта
            $this->slug = 'page/'. Functional::translite($this->name);

            return parent::beforeSave($insert);
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $map = Map::findOne(['page_id' => $this->id]);
        if($map) $map->save();
    }

    /**
     * @return mixed
     */
    static function getAllTitles(){
        $pages = ArrayHelper::map(
            Page::find()->select([
                'id', 'name'
            ])->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            'name'
        );

        return $pages;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return "/".$this->slug;
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
