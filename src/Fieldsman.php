<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman;

use Danilocgsilva\Fieldsman\Entities\FetchingResults;
use Danilocgsilva\Fieldsman\Entities\FieldEntity;
use Danilocgsilva\Fieldsman\Entities\FieldPayloadEntity;
use Danilocgsilva\Fieldsman\Entities\PayloadEntity;
use Danilocgsilva\Fieldsman\Repositories\FieldRepository;
use Danilocgsilva\Fieldsman\Repositories\FieldPayloadRepository;

class Fieldsman
{
    public function __construct(private FieldRepository $fieldRepository, private FieldPayloadRepository $fieldPayloadRepository)
    {
    }
    
    public function fetchFields(PayloadEntity $payloadEntity): FetchingResults
    {
        $jsonPayload = $payloadEntity->content;
        $payloadData = json_decode($jsonPayload, true);
        $keys = array_keys($payloadData);

        foreach ($keys as $key) {
            $newFieldEntity = $this->fieldRepository->store(new FieldEntity($key));
            $this->fieldPayloadRepository->store(new FieldPayloadEntity($newFieldEntity, $payloadEntity));
        }
        return new FetchingResults(count($keys));
    }
}