<?php

namespace common\models\query;

use common\models\OrderItem;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[OrderItem]].
 *
 * @see OrderItem
 */
class OrderItemQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return OrderItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrderItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
