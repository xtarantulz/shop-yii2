<?php

namespace common\models\query;

use common\models\Page;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
