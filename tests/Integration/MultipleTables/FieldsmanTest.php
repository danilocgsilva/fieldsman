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
        
        $this->assertCountPayloadFieldsFieldPayload(0, 0, 0);

        $pdo = RepositoryTestCase::getPdo();

        $payloadContent = <<<EOF
{
    "code": "2233dx"
}
EOF;
        $payloadEntity = $this->setAndGetPayload($pdo, $payloadContent);
        
        $this->assertCountPayloadFieldsFieldPayload(1, 0, 0);

        $fieldRepository = new FieldRepository($pdo);

        $fieldsman = new Fieldsman($fieldRepository, new FieldPayloadRepository($pdo));
        $fetched = $fieldsman->fetchFields($payloadEntity);

        $this->assertSame(1, $fetched->fetchedCount);

        $this->assertCountPayloadFieldsFieldPayload(1, 1, 1);

        $fieldCreated = $fieldRepository->getById(1);
        $this->assertSame("code", $fieldCreated->name);
    }

    public function testPostalFetchFields(): void
    {
        self::resetClassTestTables();
        
        $this->assertCountPayloadFieldsFieldPayload(0, 0, 0);

        $pdo = RepositoryTestCase::getPdo();

        $payloadContent = <<<EOF
{
    "postal": "12531-010"
}
EOF;

        $payloadEntity = $this->setAndGetPayload($pdo, $payloadContent);
        
        $this->assertCountPayloadFieldsFieldPayload(1, 0, 0);

        $fieldRepository = new FieldRepository($pdo);
        $fieldsman = new Fieldsman($fieldRepository, new FieldPayloadRepository($pdo));
        $fetched = $fieldsman->fetchFields($payloadEntity);

        $this->assertSame(1, $fetched->fetchedCount);

        $this->assertCountPayloadFieldsFieldPayload(1, 1, 1);

        $fieldCreated = $fieldRepository->getById(1);
        $this->assertSame("postal", $fieldCreated->name);
    }

    public function test2FieldsFetchFields(): void
    {
        self::resetClassTestTables();
        
        $this->assertCountPayloadFieldsFieldPayload(0, 0, 0);

        $pdo = RepositoryTestCase::getPdo();

        $payloadContent = <<<EOF
{
    "Content-Length": "568",
    "X-Real-IP": "10.158.1.61"
}
EOF;

        $payloadEntity = $this->setAndGetPayload($pdo, $payloadContent);
        
        $this->assertCountPayloadFieldsFieldPayload(1, 0, 0);

        $fieldRepository = new FieldRepository($pdo);
        $fieldsman = new Fieldsman($fieldRepository, new FieldPayloadRepository($pdo));
        $fetched = $fieldsman->fetchFields($payloadEntity);

        $this->assertSame(2, $fetched->fetchedCount);

        $this->assertCountPayloadFieldsFieldPayload(1, 2, 2);

        $fieldCreated = $fieldRepository->getById(1);
        $this->assertSame("Content-Length", $fieldCreated->name);

        $fieldCreated = $fieldRepository->getById(2);
        $this->assertSame("X-Real-IP", $fieldCreated->name);
    }

    private function assertCountPayloadFieldsFieldPayload(int $payloadCounts, int $fieldsCount, int $fieldPayloadCount): void
    {
        $this->assertSame($payloadCounts, self::countTableOccurrences("payloads"));
        $this->assertSame($fieldsCount, self::countTableOccurrences("fields"));
        $this->assertSame($fieldPayloadCount, self::countTableOccurrences("field_payload"));
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
