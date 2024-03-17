<?php

namespace common\models\query;

use common\models\Order;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Order]].
 *
 * @see Order
 */
class OrderQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
