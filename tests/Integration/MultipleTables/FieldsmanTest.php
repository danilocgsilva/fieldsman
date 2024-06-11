<?php

declare(strict_types=1);

namespace Tests\Integration\SingleTable\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Fieldsman;
use Danilocgsilva\Fieldsman\Repositories\FieldPayloadRepository;
use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use PHPUnit\Framework\TestCase;
use Tests\Integration\DatabaseTraits\UtilsTrait;
use Tests\Integration\RepositoryTestCase;
use PDO;

class FieldsmanTest extends TestCase
{
    use UtilsTrait;

    public function testCodeFetchFields(): void
    {
        self::resetClassTestTables();
        
        $this->assertSame(0, self::countTableOccurrences("payloads"));
        $this->assertSame(0, self::countTableOccurrences("fields"));
        $this->assertSame(0, self::countTableOccurrences("field_payload"));

        $pdo = RepositoryTestCase::getPdo();

        $payloadContent = <<<EOF
{
    "code": "2233dx"
}
EOF;
        $payloadEntity = $this->setAndGetPayload($pdo, $payloadContent);
        
        $this->assertSame(1, self::countTableOccurrences("payloads"));
        $this->assertSame(0, self::countTableOccurrences("fields"));
        $this->assertSame(0, self::countTableOccurrences("field_payload"));

        $fieldRepository = new FieldRepository($pdo);

        $fieldsman = new Fieldsman($fieldRepository, new FieldPayloadRepository($pdo));
        $fieldsman->fetchFields($payloadEntity);

        $this->assertSame(1, self::countTableOccurrences("payloads"));
        $this->assertSame(1, self::countTableOccurrences("fields"));
        $this->assertSame(1, self::countTableOccurrences("field_payload"));

        $fieldCreated = $fieldRepository->getById(1);
        $this->assertSame("code", $fieldCreated->name);
    }

    public function testPostalFetchFields(): void
    {
        self::resetClassTestTables();
        
        $this->assertSame(0, self::countTableOccurrences("payloads"));
        $this->assertSame(0, self::countTableOccurrences("fields"));
        $this->assertSame(0, self::countTableOccurrences("field_payload"));

        $pdo = RepositoryTestCase::getPdo();

        $payloadContent = <<<EOF
{
    "postal": "12531-010"
}
EOF;

        $payloadEntity = $this->setAndGetPayload($pdo, $payloadContent);
        
        $this->assertSame(1, self::countTableOccurrences("payloads"));
        $this->assertSame(0, self::countTableOccurrences("fields"));
        $this->assertSame(0, self::countTableOccurrences("field_payload"));

        $fieldRepository = new FieldRepository($pdo);
        $fieldsman = new Fieldsman($fieldRepository, new FieldPayloadRepository($pdo));
        $fieldsman->fetchFields($payloadEntity);

        $this->assertSame(1, self::countTableOccurrences("payloads"));
        $this->assertSame(1, self::countTableOccurrences("fields"));
        $this->assertSame(1, self::countTableOccurrences("field_payload"));

        $fieldCreated = $fieldRepository->getById(1);
        $this->assertSame("postal", $fieldCreated->name);
    }

    private function setAndGetPayload(PDO $pdo, string $content): PayloadEntity
    {
        $payloadName = "2024-05-06";

        $payloadRepository = new PayloadRepository($pdo);
        $payloadRepository->store(new PayloadEntity($payloadName, $content));
        return $payloadRepository->getById(1);
    }
    
    private static function resetClassTestTables()
    {
        self::resetTable("field_payload", self::getPdo());
        self::resetTable("payloads", self::getPdo());
        self::resetTable("fields", self::getPdo());
    }
}
