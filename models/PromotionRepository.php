<?php

namespace app\models;

use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class PromotionRepository
 *
 * @package app\models
 */
class PromotionRepository
{
    /**
     * Максимальная цена (для продажи)
     *
     * @return array|Promotion[]|null
     */
    public static function getMaxPrice(): ?array
    {
        $query = Promotion::find()->select(['id', new Expression('DATE_FORMAT(date, "%d.%m.%Y") as date'), 'price']);

        $sub_query = (new Query())->select(new Expression("MAX(price)"))->from(Promotion::tableName());

        $query->where(['price' => $sub_query]);
        $query->orderBy(['price' => SORT_DESC]);

        return $query->all();
    }

    /**
     * Минимальная цена (для покупки)
     *
     * @return array|Promotion[]|null
     */
    public static function getMinPrice(): ?array
    {
        $query = Promotion::find()->select(['id', new Expression('DATE_FORMAT(date, "%d.%m.%Y") as date'), 'price']);

        $sub_query = (new Query())->select(new Expression("MIN(price)"))->from(Promotion::tableName());

        $query->where(['price' => $sub_query]);
        $query->orderBy(['price' => SORT_ASC]);

        return $query->all();
    }

    /**
     * Все данные по акциям
     *
     * @return array|Promotion[]|null
     */
    public static function getAll(): ?array
    {
        $query = Promotion::find();
        $query->orderBy(['id' => SORT_DESC]);

        return $query->all();
    }

    /**
     * Список всех цен
     *
     * @return array
     */
    public static function getAllPrice(): array
    {
        $query = Promotion::find()->select('price');
        $query->orderBy(['id' => SORT_ASC]);

        return $query->asArray()->column();
    }

    /**
     * Список всех дат
     *
     * @return array
     */
    public static function getAllDate(): array
    {
        $query = Promotion::find()->select(new Expression('DATE_FORMAT(date, "%d.%m.%Y")'));
        $query->orderBy(['id' => SORT_ASC]);

        return $query->asArray()->column();
    }

    /**
     * Получаем запрос просчитанных данных по покупке/продаже акций
     *
     * @param Pagination|null $pagination
     *
     * @return Query
     */
    public static function getQueryCalcData(?Pagination $pagination = null): Query
    {
        $query = (new Query());

        $query->select([
            'MIN(p1.price) price_buy',
            'MAX(p2.price) price_sale',
            'DATE_FORMAT(p1.date, "%d.%m.%Y") date_buy',
            'DATE_FORMAT(p2.date, "%d.%m.%Y") date_sale',
            '(MAX(p2.price) - MIN(p1.price)) profit'
        ]);

        $query->from([Promotion::tableName() . ' p1', Promotion::tableName() . ' p2']);

        $sub_query_1 = clone $query;
        $sub_query_1->select('(MAX(p2.price) - MIN(p1.price)) profit');

        $query->groupBy(['p1.date', 'p2.date']);
        $query->having(['profit' => $sub_query_1]);

        if ($pagination !== null) {
            $query->offset($pagination->offset)->limit($pagination->limit);
        }

        $query->orderBy(['DATE_FORMAT(p1.date, "%d.%m.%Y")' => SORT_ASC]);

        return $query;
    }

    /**
     * Получаем просчитанные данные по покупке/продаже акций
     *
     * @param Pagination|null $pagination
     *
     * @return array
     */
    public static function getCalcData(?Pagination $pagination = null): array
    {
        return self::getQueryCalcData($pagination)->all();
    }

    /**
     * Получаем кол-во просчитанных данных по покупке/продаже акций
     *
     * @return int
     */
    public static function getCalcDataCount(): int
    {
        return (int)self::getQueryCalcData()->count();
    }
}