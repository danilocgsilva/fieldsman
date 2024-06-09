<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Entities;

class PayloadEntity
{
    private int $id;
    
    public function __construct(public readonly string $name, public readonly string $content)
    {
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}