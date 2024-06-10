<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class FieldEntity extends EntityAbstract
{
    public function __construct(public readonly string $name, int $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
    }
}
