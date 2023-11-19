<?php

use Iwahara\MysqlPerformance\ArrayCalculator;
use Iwahara\MysqlPerformance\MySQLPerformance;

require 'vendor/autoload.php';

$mysql57 = new MySQLPerformance('mysql57', 'performance', 'performance_user', 'performance_password');
$mysql80 = new MySQLPerformance('mysql80', 'performance', 'performance_user', 'performance_password');

function measure(MySQLPerformance $mysql, string $name)
{
    echo "${name}の検証ここから" . PHP_EOL;
    $timers = [];

    for ($i = 0; $i < 100; $i++) {
        //Bulk Insertの検証
        $timers['bulk_insert_no_index'][] = $mysql->measureBulkInsert('no_index');
        $timers['bulk_insert_index_1'][] = $mysql->measureBulkInsert('index_1');
        $timers['bulk_insert_index_2'][] = $mysql->measureBulkInsert('index_2');
        $timers['bulk_insert_index_3'][] = $mysql->measureBulkInsert('index_3');

        //各Selectの検証
        $timers['select_no_index'][] = $mysql->measureSelectNoIndex();
        $timers['select_pk_index'][] = $mysql->measureSelectPKIndex(1);
        $timers['select_index_1'][] = $mysql->measureSelectIndexOne('A_1');
        $timers['select_index_2'][] = $mysql->measureSelectIndexTwo('A_1', 'B_1');
        $timers['select_index_3'][] = $mysql->measureSelectIndexThree('A_1', 'B_1', 'C_1');

        //Truncateの検証（データあり）
        $timers['truncate_no_index'][] = $mysql->measureTruncate('no_index');
        $timers['truncate_index_1'][] = $mysql->measureTruncate('index_1');
        $timers['truncate_index_2'][] = $mysql->measureTruncate('index_2');
        $timers['truncate_index_3'][] = $mysql->measureTruncate('index_3');

        //Truncateの検証(データなし)
        $timers['truncate_no_index_no_data'][] = $mysql->measureTruncate('no_index');
        $timers['truncate_index_1_no_data'][] = $mysql->measureTruncate('index_1');
        $timers['truncate_index_2_no_data'][] = $mysql->measureTruncate('index_2');
        $timers['truncate_index_3_no_data'][] = $mysql->measureTruncate('index_3');

        //単純なInsertの検証
        $timers['insert_no_index'][] = $mysql->measureInsert('no_index');
        $timers['insert_index_1'][] = $mysql->measureInsert('index_1');
        $timers['insert_index_2'][] = $mysql->measureInsert('index_2');
        $timers['insert_index_3'][] = $mysql->measureInsert('index_3');

        //Deleteの検証(データあり)
        $timers['delete_no_index'][] = $mysql->measureDelete('no_index');
        $timers['delete_index_1'][] = $mysql->measureDelete('index_1');
        $timers['delete_index_2'][] = $mysql->measureDelete('index_2');
        $timers['delete_index_3'][] = $mysql->measureDelete('index_3');

        //Deleteの検証(データなし)
        $timers['delete_no_index_no_data'][] = $mysql->measureDelete('no_index');
        $timers['delete_index_1_no_data'][] = $mysql->measureDelete('index_1');
        $timers['delete_index_2_no_data'][] = $mysql->measureDelete('index_2');
        $timers['delete_index_3_no_data'][] = $mysql->measureDelete('index_3');

    }

    echo "タイトル\t平均\t最大\t最小\t中央\t合計" . PHP_EOL;

    foreach ($timers as $key => $timer) {
        $calc = new ArrayCalculator($timer);
        $calc->simplePrint($key);
    }

    echo "${name}の検証ここまで" . PHP_EOL;
}

measure($mysql57, 'mysql5.7');
measure($mysql80, 'mysql8.0.28');