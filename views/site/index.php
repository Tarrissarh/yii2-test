<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;
use yii\bootstrap\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Акции</h1>
    </div>
    <div class="body-content">
        <?php Pjax::begin(); ?>

        <?= Html::a("Рассчитать", ['site/index'], ['class' => 'btn btn-lg btn-primary']) ?>

        <div class="row">
            <div class="col-lg-12">
                <h2>Варианты покупок/продаж акций с максимальной прибылью</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <td>Дата покупки</td>
                        <td>Цена покупки</td>
                        <td>Дата продажи</td>
                        <td>Цена продажи</td>
                        <td>Прибыль</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($promotions['calc']['promotions'] as $key => $item): ?>
                        <tr>
                            <td><?= $item['date_buy']; ?></td>
                            <td><?= $item['price_buy']; ?></td>
                            <td><?= $item['date_sale']; ?></td>
                            <td><?= $item['price_sale']; ?></td>
                            <td><?= $item['profit']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?=

                LinkPager::widget([
                    'pagination' => $promotions['calc']['pagination'],
                ]);

                ?>
            </div>
        </div>

        <?php Pjax::end(); ?>

        <!--<div class="row">
            <div class="col-lg-6">
                <h2>Оптимальная покупка:</h2>
                <div>
                    <?php /*foreach ($promotions['min'] as $item): */?>
                        <p>Дата: <?/*= $item->date; */?><br>Цена: <?/*= $item->price; */?></p>
                    <?php /*endforeach; */?>
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Оптимальная продажа:</h2>
                <div>
                    <?php /*foreach ($promotions['max'] as $item): */?>
                        <p>Дата: <?/*= $item->date; */?><br>Цена: <?/*= $item->price; */?></p>
                    <?php /*endforeach; */?>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-lg-12">
                <?=
                ChartJs::widget(
                    [
                        'type'    => 'line',
                        'options' => [
                            'height' => 200,
                            'width'  => 400,
                        ],
                        'data'    => [
                            'labels'   => $promotions['all']['date'],
                            'datasets' => [
                                [
                                    'label'                     => "График",
                                    'backgroundColor'           => "rgba(179,181,198,0.2)",
                                    'borderColor'               => "rgba(179,181,198,1)",
                                    'pointBackgroundColor'      => "rgba(179,181,198,1)",
                                    'pointBorderColor'          => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor'     => "rgba(179,181,198,1)",
                                    'data'                      => $promotions['all']['price'],
                                ],
                            ],
                        ],
                    ]
                );
                ?>
            </div>
        </div>
    </div>
</div>
