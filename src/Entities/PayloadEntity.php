<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class PayloadEntity
{
    public function __construct(public readonly string $name, public readonly string $content)
    {
    }
}