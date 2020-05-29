<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Promotion;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class FillingContentController extends Controller
{
    /**
     * Наполнение таблицы случайными значениями цен на акции
     *
     * @throws Exception
     */
    public function actionRun()
    {
        // Дата начала интервала
        $start = new DateTime("14.02.2020");
        // Дата окончания интервала
        $end = new DateTime();
        // Интервал в один день
        $step = new DateInterval('P1D');
        // Итератор по дням
        $period = new DatePeriod($start, $step, $end);

        $params = [];

        // Вывод дней
        foreach ($period as $datetime) {
            $params[] = [
                'date'  => $datetime->format('Y-m-d'),
                'price' => random_int(3, 20),
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(
            Promotion::tableName(), ['date', 'price'], $params
        )->execute();
    }
}
