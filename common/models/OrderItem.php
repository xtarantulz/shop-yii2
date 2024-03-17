<?php

namespace common\models;

use common\models\core\Functional;
use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\query\OrderItemQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $count
 * @property string $price
 * @property int $updated_at
 * @property int $created_at
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'count', 'price'], 'required'],
            [['order_id', 'product_id', 'count', 'updated_at', 'created_at'], 'integer'],
            [['price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/', 'max' => 9999999.99],
            [['price'], 'filter', 'filter' => function ($value) {
                $value = Functional::floorDecimal(1 * str_replace(',', '.', $value), 2);
                return $value;
            }],
            //[['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            //[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Заказ'),
            'product_id' => Yii::t('app', 'Товар'),
            'count' => Yii::t('app', 'Кількість'),
            'price' => Yii::t('app', 'Цена'),
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

    /**
     * @return float
     */
    public function getSum()
    {
        return Functional::floorDecimal($this->price * $this->count, 2);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderItemQuery(get_called_class());
    }
}
