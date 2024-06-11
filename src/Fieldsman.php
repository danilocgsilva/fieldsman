<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman;

use Danilocgsilva\Fieldsman\Entities\FetchingResults;
use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\FieldRepository;

class Fieldsman
{
    public function __construct(private FieldRepository $fieldRepository)
    {
    }
    
    public function fetchFields(PayloadEntity $payloadEntity): FetchingResults
    {
        // $payloadData = json_decode($payloadEntity->content, true);
        
    }
}