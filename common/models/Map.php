<?php

namespace common\models;

use common\models\query\MapQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort_order
 * @property integer $page_id
 * @property string $controller
 * @property string $action
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Map $parent
 * @property Map[] $maps
 * @property Page $page
 *
 */
class Map extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'sort_order'], 'integer'],
            [['parent_id', 'page_id'], 'integer'],
            [['name', 'controller', 'action'], 'string', 'max' => 255],
            ['sort_order', 'default', 'value' => 0],

            //[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => Yii::t('app', 'Батьківське меню'),
            'sort_order' => Yii::t('app', 'Сортування'),
            'page_id' => Yii::t('app', 'Сторінка'),
            'controller' => Yii::t('app', 'Контролер'),
            'action' => Yii::t('app', 'Дія'),
            'created_at' => Yii::t('app', 'Створено'),
            'updated_at' => Yii::t('app', 'Оновлено'),
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //урлы на карте сайта
            if(!$this->page_id){
                $this->page_id = null;
                $this->slug = $this->controller."/".$this->action;
            }else{
                $this->slug = $this->page->slug;
            }

            return parent::beforeSave($insert);
        } else {
            return false;
        }
    }


    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Map::className(), ['id' => 'parent_id'])->from(Map::tableName() . ' parent');
    }

    /**
     * @return ActiveQuery
     */
    public function getMaps()
    {
        return $this->hasMany(Map::className(), ['parent_id' => 'id'])->from(Map::tableName() . ' maps');
    }

    /**
     * @return ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return mixed
     */
    static function getAllNamesMap(){
        $maps = ArrayHelper::map(
            Map::find()->select([
                'id', 'name'
            ])->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            'name'
        );

        return $maps;
    }

    /**
     * @param $options array
     * @return mixed
     */
    public static function getTree($options = [])
    {
        $depth = ArrayHelper::remove($options, 'depth', -1);
        $filter = ArrayHelper::remove($options, 'filter', function ($item) {
            return true;
        });

        $list = self::find()->all();
        $list = ArrayHelper::remove($options, 'list', $list);

        $getChildren = function ($id, $depth) use ($list, &$getChildren, $filter) {
            $result = [];
            foreach ($list as $item) {
                if ((int)$item['parent_id'] === (int)$id) {
                    $r = [
                        'name' => $item['name'],
                        'id' => $item['id'],
                        'sort_order' => $item['sort_order'],
                        'slug' => $item['slug'],

                    ];
                    $c = $depth ? $getChildren($item['id'], $depth - 1) : null;
                    if (!empty($c)) {
                        $r['children'] = $c;
                    }
                    if ($filter($r)) {
                        $result[] = $r;
                    }
                }
            }

            usort($result, function ($a, $b) {
                return $a['sort_order'] > $b['sort_order'];
            });

            return $result;

        };

        return $getChildren(0, $depth);
    }

    /**
     * @param $id integer
     * @param $level integer
     * @param $prefix string
     * @return mixed
     */
    public static function forSelectTree($id = null, $level = 1, $prefix = '-')
    {
        $return = [];
        $prefix = str_repeat($prefix, $level);
        if ($level > 0) $prefix .= ' ';
        $level++;

        $services = Map::find()->where(['parent_id' => $id])->orderBy(['sort_order' => SORT_ASC])->all();

        foreach ($services as $service) {
            $return[$service->id] = "$prefix{$service->name}";
            $return = $return + self::forSelectTree($service->id, $level);
        }

        return $return;
    }

    /**
     * @param $id integer
     * @return mixed
     */
    public static function forSelectGroup($id = null)
    {
        $return = [];
        $services = Map::find()->where(['parent_id' => $id])->orderBy(['sort_order' => SORT_ASC])->all();

        foreach ($services as $service) {
            $child = self::forSelectGroup($service->id);
            if(is_array($child) && count($child)){
                $return[$service->name] = self::forSelectGroup($service->id);
            }else{
                $return[$service->id] = $service->name;
            }

        }

        return $return;
    }


    /**
     * @param $id integer
     * @param $result array
     * @return mixed
     */
    public static function getParentsMapsIds($id, $result = [])
    {
        $service = Map::findOne($id);
        if ($service && $service->parent_id) {
            $result = Map::getParentsMapsIds($service->parent_id, $result);
        }

        $result[] = $id;
        return $result;
    }

    /**
     * @param $id integer
     * @param $result array
     * @return mixed
     */
    public static function getChildMapsIds($id, $result = [])
    {
        $services = Map::findAll(['parent_id' => $id]);
        foreach ($services as $service) {
            $result = Map::getChildMapsIds($service->id, $result);
        }

        $result[] = $id;
        return $result;
    }

    /**
     * @param $id integer
     * @param $result array
     * @return mixed
     */
    public static function getParentsMaps($id, $result = [])
    {
        $step = Map::findOne($id);
        if ($step && $step->parent_id) {
            $result = Map::getParentsMaps($step->parent_id, $result);
        }

        $result[] = $step;
        return $result;
    }

    /**
     * {@inheritdoc}
     * @return MapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapQuery(get_called_class());
    }
}
