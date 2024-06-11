<?php

declare(strict_types=1);

namespace Tests\Integration\DatabaseTraits;

use PDO;

trait UtilsTrait
{
    protected function countTableOccurrences(string $tableName, PDO $pdo): int
    {
        $queryCount = "SELECT COUNT(*) FROM %s;";
        $preResults = $pdo->prepare(sprintf($queryCount, $tableName));
        $preResults->execute();
        $preResults->setFetchMode(PDO::FETCH_NUM);
        $row = $preResults->fetch();
        return $row[0];
    }
}
