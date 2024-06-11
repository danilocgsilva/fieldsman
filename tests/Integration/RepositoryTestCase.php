<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;

class RepositoryTestCase extends TestCase
{
    protected PDO $pdo;

    public function setUp(): void
    {
        $this->pdo = self::getPdo();
    }



    protected static function resetTable(string $tableName, PDO $pdo): void
    {
        $queryDelete = "DELETE FROM %s; ALTER TABLE %s AUTO_INCREMENT = 1;";
        $preResults = $pdo->prepare(sprintf($queryDelete, $tableName, $tableName));
        $preResults->execute();
    }

    protected static function resetFieldsPayloads(PDO $pdo): void
    {
        self::resetTable("field_payload", $pdo);
        self::resetTable("fields", $pdo);
        self::resetTable("payloads", $pdo);
    }

    public static function getPdo(): PDO
    {
        return new PDO(
            sprintf("mysql:host=%s;dbname=%s", getenv("FIELDSMAN_TEST_DB_HOST"), "fieldsman_test"),
            getenv("FIELDSMAN_TEST_DB_USER"),
            getenv("FIELDSMAN_TEST_DB_PASSWORD")
        );
    }
}
