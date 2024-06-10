<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class FieldPayloadEntity extends EntityAbstract
{
    public function __construct(public readonly FieldEntity $fieldEntity, public readonly PayloadEntity $payloadEntity)
    {
    }
}
