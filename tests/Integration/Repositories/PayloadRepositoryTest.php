<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Tests\Integration\Repositories;

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
        $payloadRepository = new PayloadRepository($this->pdo);
        $this->assertTrue(false);
    }
}