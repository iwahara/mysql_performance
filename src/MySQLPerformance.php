<?php

namespace Iwahara\MysqlPerformance;


use PDO;

class MySQLPerformance
{
    private PDO $pdo;

    const COUNT = 1000;

    public function __construct(string $host, string $db, string $user, string $password)
    {
        $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function measureSelectNoIndex(): float
    {
        $start_time = microtime(true);

        $query = "SELECT * FROM no_index";
        $stmt = $this->pdo->query($query);
        $stmt->fetchAll();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureSelectPKIndex(string $id): float
    {
        $start_time = microtime(true);

        $query = "SELECT * FROM no_index WHERE id = $id";
        $stmt = $this->pdo->query($query);
        $stmt->fetchAll();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureSelectIndexOne(string $code1): float
    {
        $start_time = microtime(true);

        $query = "SELECT * FROM index_1 WHERE `code1` = '$code1'";
        $stmt = $this->pdo->query($query);
        $stmt->fetchAll();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureSelectIndexTwo(string $code1, string $code2): float
    {
        $start_time = microtime(true);

        $query = "SELECT * FROM index_2 WHERE code1 = '$code1' and code2 = '$code2'";
        $stmt = $this->pdo->query($query);
        $stmt->fetchAll();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureSelectIndexThree(string $code1, string $code2, string $code3): float
    {
        $start_time = microtime(true);

        $query = "SELECT * FROM index_3 WHERE code1 = '$code1' and code2 = '$code2' and code3 = '$code3'";
        $stmt = $this->pdo->query($query);
        $stmt->fetchAll();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureInsert(string $table): float
    {
        $start_time = microtime(true);

        $this->pdo->beginTransaction();
        for ($i = 1; $i <= self::COUNT; $i++) {
            $query = "INSERT INTO $table (`id`, `name`,`code1`,`code2`,`code3`) VALUES (:id, :name, :code1, :code2, :code3)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $i);
            $name = "名前_$i";
            $stmt->bindParam(':name', $name);
            $code1 = "A_$i";
            $stmt->bindParam(':code1', $code1);
            $code2 = "B_$i";
            $stmt->bindParam(':code2', $code2);
            $code3 = "C_$i";
            $stmt->bindParam(':code3', $code3);
        }
        $this->pdo->commit();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureDelete(string $table): float
    {
        $start_time = microtime(true);

        $query = "DELETE FROM $table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureBulkInsert(string $table): float
    {
        $start_time = microtime(true);

        $this->pdo->beginTransaction();


        $query = "INSERT INTO $table (`id`, `name`,`code1`,`code2`,`code3`) VALUES ";
        $values = [];
        for ($i = 1; $i <= self::COUNT; $i++) {
            $values[] = [$i, "名前_$i", "A_$i", "B_$i", "C_$i"];
        }

        // 各行の値を挿入するためのプレースホルダを生成
        $placeholders = implode(',', array_fill(0, count($values), '(?, ?, ?, ?, ?)'));
        $query .= $placeholders;

        $stmt = $this->pdo->prepare($query);

        // 各行の値を一括でバインドして実行
        $valuesToBind = [];
        foreach ($values as $row) {
            $valuesToBind = array_merge($valuesToBind, $row);
        }
        $stmt->execute($valuesToBind);


        $this->pdo->commit();

        $end_time = microtime(true);
        return $end_time - $start_time;
    }

    public function measureTruncate(string $table): float
    {
        $start_time = microtime(true);

        $query = "TRUNCATE TABLE $table";
        $this->pdo->exec($query);

        $end_time = microtime(true);
        return $end_time - $start_time;
    }
}