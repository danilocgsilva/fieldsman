<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;
use Tests\Integration\DatabaseTraits\UtilsTrait;

class RepositoryTestCase extends TestCase
{
    use UtilsTrait;
    
    protected PDO $pdo;

    public function setUp(): void
    {
        $this->pdo = self::getPdo();
    }

    protected static function resetFieldsPayloads(PDO $pdo): void
    {
        self::resetTable("field_payload", $pdo);
        self::resetTable("fields", $pdo);
        self::resetTable("payloads", $pdo);
    }
}
