<?php

namespace common\models\query;

use common\models\ProductField;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProductField]].
 *
 * @see ProductField
 */
class ProductFieldQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ProductField[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductField|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
