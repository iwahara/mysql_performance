<?php

namespace Iwahara\MysqlPerformance;

class ArrayCalculator
{
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function average(): float
    {
        $count = count($this->values);
        $sum = array_sum($this->values);

        return $sum / $count;
    }

    public function max(): float
    {
        return max($this->values);
    }

    public function min(): float
    {
        return min($this->values);
    }

    public function median(): float
    {
        sort($this->values);
        $count = count($this->values);
        $middle = (int)($count / 2);

        if ($count % 2 == 0) {
            // 要素数が偶数の場合
            $median = ($this->values[$middle - 1] + $this->values[$middle]) / 2;
        } else {
            // 要素数が奇数の場合
            $median = $this->values[$middle];
        }

        return $median;
    }

    public function sum(): float
    {
        return array_sum($this->values);
    }

    public function getResult(): array
    {
        return [
            '平均' => $this->average(),
            '最大' => $this->max(),
            '最小' => $this->min(),
            '中央' => $this->median(),
            '合計' => $this->sum(),
        ];
    }

    public function simplePrint($title)
    {
        $msg = sprintf("%.10f\t%.10f\t%.10f\t%.10f\t%.10f",
            $this->average(), $this->max(), $this->min(), $this->median(), $this->sum()
        );

        echo "${title}\t" . $msg . PHP_EOL;
    }

    public function print(string $title)
    {
        $msg = sprintf("平均[%.10f秒]\t最大[%.10f秒]\t最小[%.10f秒]\t中央[%.10f秒]\t合計[%.10f秒]",
            $this->average(), $this->max(), $this->min(), $this->median(), $this->sum()
        );

        echo "${title}\t" . $msg . PHP_EOL;
    }
}