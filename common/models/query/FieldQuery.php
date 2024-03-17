<?php

namespace common\models\query;

use common\models\Field;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Field]].
 *
 * @see Field
 */
class FieldQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Field[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Field|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
