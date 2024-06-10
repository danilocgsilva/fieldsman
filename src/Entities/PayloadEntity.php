<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class PayloadEntity extends EntityAbstract
{    
    public function __construct(public readonly string $name, public readonly string $content, int $id = null)
    {
        if ($id) {
            $this->setId($id);
        }
    }
}