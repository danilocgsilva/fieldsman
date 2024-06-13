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

    private FieldRepository $fieldRepository;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->fieldRepository = new FieldRepository($this->pdo);
    }

    public function test1Store(): void
    {
        self::resetTable("fields", $this->pdo);
        $this->assertSame(0, self::countTableOccurrences("fields"));
        
        $name = "ips";
        
        $field = new FieldEntity($name);
        $justCreatedField = $this->fieldRepository->store($field);

        $this->assertSame(1, self::countTableOccurrences("fields"));
        $this->assertSame(1, $justCreatedField->getId());
    }

    public function testFindById()
    {
        self::resetTable("fields", $this->pdo);
        $this->assertSame(0, self::countTableOccurrences("fields"));
        
        $this->createFieldRegister($this->fieldRepository);

        $storedField = $this->fieldRepository->getById(1);

        $this->assertSame(1, $storedField->getId());
    }

    public function testFalseExistsByName(): void
    {
        self::resetTable("fields", $this->pdo);
        $this->assertFalse($this->fieldRepository->existsByName("some-name"));
    }

    public function testTrueExistsByName(): void
    {
        self::resetTable("fields", $this->pdo);

        $this->assertFalse($this->fieldRepository->existsByName("some-name"));

        $name = "some-name";
        $field = new FieldEntity($name);
        $this->fieldRepository->store($field);
        
        $this->assertTrue($this->fieldRepository->existsByName($name));
    }

    private function createFieldRegister(FieldRepository $fieldsRepository): void
    {
        $name = "postalcode";
        $field = new FieldEntity($name);
        $fieldsRepository->store($field);
    }
}
