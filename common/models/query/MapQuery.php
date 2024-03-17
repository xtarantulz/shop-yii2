<?php

namespace common\models\query;

use common\models\Map;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Map]].
 *
 * @see Map
 */
class MapQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Map[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Map|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
