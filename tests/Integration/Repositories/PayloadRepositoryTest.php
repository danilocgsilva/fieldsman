<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use PHPUnit\Framework\TestCase;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use PDO;

class PayloadRepositoryTest extends TestCase
{
    private PDO $pdo;

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
        $this->assertSame(0, $this->countPayloads());
        
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
    }

    private function countPayloads(): int
    {
        $queryCount = "SELECT COUNT(*) FROM payloads;";
        $preResults = $this->pdo->prepare($queryCount);
        $preResults->execute();
        $preResults->setFetchMode(PDO::FETCH_NUM);
        $row = $preResults->fetch();
        return $row[0];
    }
}