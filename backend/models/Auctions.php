<?php

namespace backend\models;

use yii\db\ActiveRecord;

class Auctions extends ActiveRecord
{
    public static function tableName()
    {
        return '{{auctions}}';
    }
}