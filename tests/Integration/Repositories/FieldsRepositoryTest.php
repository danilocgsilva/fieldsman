<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Entities\FieldEntity;
use Danilocgsilva\Fieldsman\Tests\Integration\Repositories\Traits\RepositoriesTestsTraits;
use PDO;
use PHPUnit\Framework\TestCase;


class FieldsRepositoryTest extends TestCase
{
    protected PDO $pdo;
    
    public function setUp(): void
    {
        $this->pdo = new PDO(
            sprintf("mysql:host=%s;dbname=%s", getenv("FIELDSMAN_TEST_DB_HOST"), "fieldsman_test"),
            getenv("FIELDSMAN_TEST_DB_USER"), 
            getenv("FIELDSMAN_TEST_DB_PASSWORD")
        );
    }

    public function test1Store(): void
    {
        $this->resetTable("fields");
        $this->assertSame(0, $this->countPayloads("fields"));
        
        $fieldsRepository = new FieldRepository($this->pdo);

        $name = "ips";
        
        $field = new FieldEntity($name);
        $fieldsRepository->store($field);

        $this->assertSame(1, $this->countPayloads("fields"));
    }

    protected function countPayloads(string $tableName): int
    {
        $queryCount = "SELECT COUNT(*) FROM %s;";
        $preResults = $this->pdo->prepare(sprintf($queryCount, $tableName));
        $preResults->execute();
        $preResults->setFetchMode(PDO::FETCH_NUM);
        $row = $preResults->fetch();
        return $row[0];
    }

    protected function resetTable(string $tableName): void
    {
        $queryDelete = "DELETE FROM %s; ALTER TABLE %s AUTO_INCREMENT = 1;";
        $preResults = $this->pdo->prepare(sprintf($queryDelete, $tableName, $tableName));
        $preResults->execute();
    }
}