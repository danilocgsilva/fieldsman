<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories;

use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Entities\FieldEntity;

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

    public function testFindById()
    {
        $this->resetTable("fields");
        $this->assertSame(0, $this->countPayloads("fields"));
        
        $fieldsRepository = new FieldRepository($this->pdo);

        $this->createFieldRegister($fieldsRepository);

        $storedField = $fieldsRepository->getById(1);

        $this->assertSame(1, $storedField->getId());
    }

    private function createFieldRegister(FieldRepository $fieldsRepository): void
    {
        $name = "postalcode";
        $field = new FieldEntity($name);
        $fieldsRepository->store($field);
    }
}
