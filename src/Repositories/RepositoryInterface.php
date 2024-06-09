<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use Danilocgsilva\Fieldsman\Entities\AbstractEntity;

interface RepositoryInterface
{
    public function all(): array;

    public function getById(int $id);

    public function update(int $id, AbstractEntity $entity);

    public function store($entity);

    public function destroy($entity): bool;
}
