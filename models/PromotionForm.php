<?php

namespace app\models;

use yii\base\Model;

/**
 * Class Promotion
 *
 * @package app\models
 */
class PromotionForm extends Model
{
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