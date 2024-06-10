<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Entities\FieldEntity;
use PDO;

class FieldsRepositoryTest extends RepositoryTestCase
{
    public function test1Store(): void
    {
        $this->resetTable("fields");
        $this->assertSame(0, $this->countPayloads("fields"));
        
        $fieldsRepository = new FieldRepository($this->pdo);

        $name = "ips";
        
        $field = new FieldEntity($name);
        $fieldsRepository->store($field);

        $this->assertSame(1, $this->countPayloads("fields"));
    }
}
