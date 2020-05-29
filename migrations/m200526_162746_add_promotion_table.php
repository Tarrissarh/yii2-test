<?php

use yii\db\Migration;

/**
 * Class m200526_162746_add_promotion_table
 */
class m200526_162746_add_promotion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%promotion}}',
            [
                'id'    => $this->primaryKey(10)->unsigned(),
                'date'  => $this->date(),
                'price' => $this->double(2),
            ],
            $tableOptions
        );

        Yii::$app->db->createCommand()->batchInsert(
            '{{%promotion}}', ['date', 'price'], [
                [
                    'date'  => '2020-02-01',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-02',
                    'price' => 3,
                ],
                [
                    'date'  => '2020-02-03',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-04',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-05',
                    'price' => 3,
                ],
                [
                    'date'  => '2020-02-06',
                    'price' => 5,
                ],
                [
                    'date'  => '2020-02-07',
                    'price' => 6,
                ],
                [
                    'date'  => '2020-02-08',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-09',
                    'price' => 3,
                ],
                [
                    'date'  => '2020-02-10',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-11',
                    'price' => 4,
                ],
                [
                    'date'  => '2020-02-12',
                    'price' => 6,
                ],
                [
                    'date'  => '2020-02-13',
                    'price' => 7,
                ],
                [
                    'date'  => '2020-02-14',
                    'price' => 7,
                ],
            ]
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promotion}}');
    }
}
