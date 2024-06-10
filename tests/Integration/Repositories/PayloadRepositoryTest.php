<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class PayloadRepositoryTest extends RepositoryTestCase
{
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
}