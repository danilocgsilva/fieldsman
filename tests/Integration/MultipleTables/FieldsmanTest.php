<?php

declare(strict_types=1);

namespace Tests\Integration\SingleTable\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Fieldsman;
use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Repositories\PayloadRepository;
use PHPUnit\Framework\TestCase;
use Tests\Integration\RepositoryTestCase;

class FieldsmanTest extends TestCase
{
    public function testFetchFields(): void
    {
        $pdo = RepositoryTestCase::getPdo();
        $this->setPayload($pdo);        
        $fieldsman = new Fieldsman(new FieldRepository($pdo));
    }

    private function setPayload($pdo): void
    {
        $payloadName = "2024-05-06";
        $payloadContent = <<<EOF
{
    "code": "2233dx"
}
EOF;
        $payloadRepository = new PayloadRepository($pdo);
        $payloadRepository->store(new PayloadEntity($payloadName, $payloadContent));
    }
}
