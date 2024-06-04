<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman;

interface RepositoryInterface
{
    /** @var \Danilocgsilva\Fieldsman\FieldEntity[] */
    public function all(): array;

    public function getById(int $id): FieldEntity;

    public function update(FieldEntity $fieldEntity): FieldEntity;

    public function store(FieldEntity $fieldEntity): FieldEntity;

    public function destroy(FieldEntity $fieldEntity): bool;
}
