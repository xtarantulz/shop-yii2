<?php

namespace common\models\query;

use common\models\CategoryField;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CategoryField]].
 *
 * @see CategoryField
 */
class CategoryFieldQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return CategoryField[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoryField|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
