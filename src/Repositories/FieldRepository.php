<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use PDO;

class FieldRepository
{
    public function __construct(private PDO $pdo)
    {
        
    }

    /** @var \Danilocgsilva\Fieldsman\Entities\FieldEntity[] */
    public function all(): array
    {
        
    }

    public function getById(int $id): FieldEntity
    {
        "SELECT %s, %s FROM fields WHERE id = :id;";
    }

    public function update(FieldEntity $fieldEntity): FieldEntity
    {
    }

    public function store(FieldEntity $fieldEntity): FieldEntity
    {
    }

    public function destroy(FieldEntity $fieldEntity): bool
    {
    }
}
