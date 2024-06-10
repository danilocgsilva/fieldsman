<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use Danilocgsilva\Fieldsman\Entities\FieldPayloadEntity;

class FieldPayloadRepository extends AbstractRepository
{
    /** @var \Danilocgsilva\Fieldsman\Entities\FieldPayloadEntity[] */
    public function all(): array
    {
        $preResults = $this->getPreResults("SELECT `field_id`, `payload_id` FROM `field_payload`;");

        /** @var \Danilocgsilva\Fieldsman\Entities\FieldPayloadEntity[] */
        $results = [];
        while ($row = $preResults->fetch()) {
            $results[] = new FieldPayloadEntity(
                $row[0],
                $row[1]
            );
        }
        return $results;
    }

    public function getById(int $id): FieldPayloadEntity
    {
        $preResults = $this->getPreResults("SELECT `field_id`, `payload_id` FROM `field_payload` WHERE id = :id;", [
            ':id' => $id
        ]);

        $row = $preResults->fetch();

        return new FieldPayloadEntity(
            $row[0],
            $row[1]
        );
    }

    public function update(int $id, FieldPayloadEntity $fieldPayloadEntity): FieldPayloadEntity
    {
        $this->getPreResults("UPDATE `field_payload` SET `field_id` = :field_id, `payload_id` = :payload_id WHERE `id` = :id;", [
            ':field_id' => $fieldPayloadEntity->fieldEntity->getId(),
            ':payload_id' => $fieldPayloadEntity->payloadEntity->getId(),
            ':id' => $id,
        ]);

        return $fieldPayloadEntity;
    }

    public function store(FieldPayloadEntity $fieldPayloadEntity): FieldPayloadEntity
    {
        $query = "INSERT INTO `field_payload` (`field_id`, `payload_id`) VALUES (:field_id, :payload_id);";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute([
            ':field_id' => $fieldPayloadEntity->fieldEntity->getId(),
            ':payload_id' => $fieldPayloadEntity->payloadEntity->getId()
        ]);
        return $fieldPayloadEntity;
    }

    public function destroy(FieldPayloadEntity $fieldPayloadEntity): bool
    {
        $this->getPreResults("DELETE FROM `field_payload` WHERE `id` = :id;", [
            ':id' => $fieldPayloadEntity->getId()
        ]);
        return true;
    }
}
