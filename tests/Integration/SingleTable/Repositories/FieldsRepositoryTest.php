<?php

declare(strict_types=1);

namespace Tests\Integration\SingleTable\Repositories;

use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Entities\FieldEntity;
use Tests\Integration\RepositoryTestCase;
use Tests\Integration\DatabaseTraits\UtilsTrait;

class FieldsRepositoryTest extends RepositoryTestCase
{
    use UtilsTrait;

    public function test1Store(): void
    {
        self::resetTable("fields", $this->pdo);
        $this->assertSame(0, $this->countTableOccurrences("fields", $this->pdo));
        
        $fieldsRepository = new FieldRepository($this->pdo);

        $name = "ips";
        
        $field = new FieldEntity($name);
        $fieldsRepository->store($field);

        $this->assertSame(1, $this->countTableOccurrences("fields", $this->pdo));
    }

    public function testFindById()
    {
        self::resetTable("fields", $this->pdo);
        $this->assertSame(0, $this->countTableOccurrences("fields", $this->pdo));
        
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
