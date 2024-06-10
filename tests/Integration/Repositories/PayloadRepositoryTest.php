<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use PDO;
use PHPUnit\Framework\TestCase;
use Danilocgsilva\Fieldsman\Tests\Integration\Repositories\Traits\RepositoriesTestsTraits;

class PayloadRepositoryTest extends TestCase
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
        $this->resetTable("payloads");
        $this->assertSame(0, $this->countPayloads("payloads"));
        
        $payloadRepository = new PayloadRepository($this->pdo);

        $payloadName = "2024-05-01-120000";
        $payloadContent = <<<EOF
{
    "name": "John Doe",
    "age": "22",
    "occupy": "develo;er",
    "nationality": "Germany"
}
EOF;
        
        $payload = new PayloadEntity($payloadName, $payloadContent);
        $payloadRepository->store($payload);

        $this->assertSame(1, $this->countPayloads("payloads"));
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