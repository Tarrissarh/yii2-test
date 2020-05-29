<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Promotion
 *
 * @package app\models
 */
class Promotion extends ActiveRecord
{
    /** @inheritDoc */
    public static function tableName()
    {
        return '{{%promotion}}';
    }

    /** @inheritDoc */
    public function rules()
    {
        return [
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['price', 'double'],
        ];
    }

    /** @inheritDoc */
    public function attributeLabels()
    {
        return [
            'date'  => 'Дата',
            'price' => 'Цена',
        ];
    }
}