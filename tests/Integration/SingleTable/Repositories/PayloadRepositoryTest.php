<?php

declare(strict_types=1);

namespace Tests\Integration\SingleTable\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use Tests\Integration\RepositoryTestCase;
use Tests\Integration\DatabaseTraits\UtilsTrait;

class PayloadRepositoryTest extends RepositoryTestCase
{
    use UtilsTrait;

    public function test1Store(): void
    {
        self::resetTable("payloads", $this->pdo);
        $this->assertSame(0, $this->countTableOccurrences("payloads", $this->pdo));
        
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

        $this->assertSame(1, self::countTableOccurrences("payloads"));
    }

    public function testGetId(): void
    {
        self::resetTable("payloads", $this->pdo);
        $payloadRepository = new PayloadRepository($this->pdo);
        $this->createPayloadStore($payloadRepository);
        $storedPayload = $payloadRepository->getById(1);
        $this->assertSame(1, $storedPayload->getId());
    }

    private function createPayloadStore(PayloadRepository $payloadRepository): void
    {
        $payloadName = "postalcode";
        $payloadContent = <<<EOF
{
    "address": "Melborn street",
    "pair": "Wanessa"
}
EOF;

        $payloadEntity = new PayloadEntity($payloadName, $payloadContent);
        $payloadRepository->store($payloadEntity);
    }
}