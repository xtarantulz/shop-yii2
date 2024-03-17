<?php

namespace common\models;

use common\models\core\Functional;
use Yii;
use yii\db\ActiveRecord;
use common\models\query\OrderQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $email
 * @property string $total
 * @property int $status
 * @property int $updated_at
 * @property int $created_at
 *
 * @property User $user
 * @property OrderItem[] $orderItems
 * @property string $fullName
 */
class Order extends ActiveRecord
{
    const STATUS_CANCELED = -1;
    const STATUS_WAITING = 0;
    const STATUS_APPROVED = 1;

    /**
     * @param $name string
     * @return array
     */
    public static function getLabels($name)
    {
        $labels = [
            'status' => [
                self::STATUS_WAITING => Yii::t('app', 'В очікуванні'),
                self::STATUS_APPROVED => Yii::t('app', 'Підтверджено'),
                self::STATUS_CANCELED => Yii::t('app', 'Скасовано'),
            ],
        ];

        return $labels[$name];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name', 'phone', 'email', 'total', 'status'], 'required'],
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['total'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/', 'max' => 9999999.99],
            [['total'], 'filter', 'filter' => function ($value) {
                $value = Functional::floorDecimal(1 * str_replace(',', '.', $value), 2);
                return $value;
            }],
            [['first_name', 'last_name', 'middle_name', 'phone', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'validatePhone'],
            ['status', 'default', 'value' => self::STATUS_WAITING],
            ['status', 'in', 'range' => [self::STATUS_WAITING, self::STATUS_APPROVED, self::STATUS_CANCELED]],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Користувач'),
            'fullName' => Yii::t('app', 'Одержувач'),
            'first_name' => Yii::t('app', 'Ім\'я'),
            'last_name' => Yii::t('app', 'Прізвище'),
            'middle_name' => Yii::t('app', 'По батькові'),
            'phone' => Yii::t('app', 'Телефон'),
            'email' => Yii::t('app', 'E-mail'),
            'total' => Yii::t('app', 'Разом'),
            'status' => Yii::t('app', 'Статус'),
            'updated_at' => Yii::t('app', 'Оновлений'),
            'created_at' => Yii::t('app', 'Створений'),
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

    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!preg_match("/^[\d]+$/", $this->phone) || strlen($this->phone) != 9) {
                $this->addError($attribute, Yii::t('app', 'Некоретний телефон'));
            }
        }
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->last_name . " " . $this->first_name . " " . $this->middle_name;
    }

    public function saveItems($post)
    {
        $models = [];
        $ids = [];

        if (isset($post['OrderItem'])) {
            foreach ($post['OrderItem'] as $item) {
                if(isset($item['product_id']) && $item['product_id']){
                    $orderItem = null;
                    if(isset($item['id']) && $item['id']) $orderItem = OrderItem::findOne($item['id']);
                    if (!$orderItem) $orderItem = new OrderItem();

                    $load['OrderItem'] = $item;
                    $orderItem->load($load);
                    if ($this->id) {
                        $orderItem->order_id = $this->id;
                        if ($orderItem->save()) {
                            $ids[] = $orderItem->id;
                        } else {
                            $this->addError('OrderItem', Yii::t('app', 'error'));
                        }
                    }

                    $models[] = $orderItem;
                }

            }
        }

        if (count($ids) > 0) OrderItem::deleteAll('id not in (' . implode(',', $ids) . ') and order_id = ' . $this->id);

        if (count($models) == 0) {
            $models = [new OrderItem()];
        }
        return $models;
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }
}
