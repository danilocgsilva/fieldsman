<?php

declare(strict_types=1);

namespace Tests\Integration\MultipleTables\Repositories;

use Danilocgsilva\Fieldsman\Entities\FieldEntity;
use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use Danilocgsilva\Fieldsman\Repositories\FieldPayloadRepository; 
use Danilocgsilva\Fieldsman\Entities\FieldPayloadEntity;
use Tests\Integration\RepositoryTestCase;
use Tests\Integration\DatabaseTraits\UtilsTrait;

class FieldPayloadRepositoryTest extends RepositoryTestCase
{
    use UtilsTrait;
    
    public function test1Store(): void
    {
        self::resetFieldsPayloads($this->pdo);
        $this->assertSame(0, $this->countTableOccurrences("field_payload", $this->pdo));

        $fieldEntity = $this->storeAndGetField();
        $payloadEntity = $this->storeAndGetPayload();
        $fieldPayloadRepository = new FieldPayloadRepository($this->pdo);

        $fieldPayloadRepository->store(new FieldPayloadEntity($fieldEntity, $payloadEntity));

        $this->assertSame(1, $this->countTableOccurrences("field_payload", $this->pdo));
    }

    private function storeAndGetPayload(): PayloadEntity
    {
        $payloadName = "second-one";
        $payloadContent = <<<EOF
{
    "contact": "mymail@somemail.com,
    "number": "9",
    "code: "33231"
}
EOF;
        $payloadEntity = new PayloadEntity($payloadName, $payloadContent);
        $payloadRepository = new PayloadRepository($this->pdo);
        $payloadRepository->store($payloadEntity);
        return $payloadRepository->getById(1);
    }

    private function storeAndGetField(): FieldEntity
    {
        $fieldRepository = new FieldRepository($this->pdo);
        $fieldRepository->store(new FieldEntity("contact"));
        return $fieldRepository->getById(1);
    }

    public static function tearDownAfterClass(): void
    {
        self::resetFieldsPayloads(self::getPdo());
    }
}
