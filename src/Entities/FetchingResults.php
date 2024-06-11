<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class FetchingResults
{
    public function __construct(public readonly int $fetchedCount)
    {
    }
}
