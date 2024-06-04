<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman;

use PDO;

class FieldRepository implements RepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
        
    }

    /** @var \Danilocgsilva\Fieldsman\FieldEntity[] */
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
