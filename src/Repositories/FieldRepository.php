<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use Danilocgsilva\Fieldsman\Entities\FieldEntity;

class FieldRepository extends AbstractRepository
{
    /** @var \Danilocgsilva\Fieldsman\Entities\FieldEntity[] */
    public function all(): array
    {
        $preResults = $this->getPreResults("SELECT `name` FROM `fields`;");

        /** @var \Danilocgsilva\Fieldsman\Entities\FieldEntity[] */
        $results = [];
        while ($row = $preResults->fetch()) {
            $results[] = new FieldEntity(
                $row[0]
            );
        }
        return $results;
    }

    public function getById(int $id): FieldEntity
    {
        $preResults = $this->getPreResults("SELECT `id`, `name` FROM `fields` WHERE id = :id;", [
            ':id' => $id
        ]);

        $row = $preResults->fetch();

        return new FieldEntity(
            $row[1],
            $row[0]
        );
    }

    public function update(int $id, FieldEntity $fieldEntity): FieldEntity
    {
        $this->getPreResults("UPDATE `fields` SET `name` = :name WHERE `id` = :id;", [
            ':name' => $fieldEntity->name,
            ':id' => $id,
        ]);

        return $fieldEntity;
    }

    public function store(FieldEntity $fieldEntity): void
    {
        $query = "INSERT INTO `fields` (`name`) VALUES (:name);";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute([
            ':name' => $fieldEntity->name
        ]);
    }

    public function destroy(FieldEntity $fieldEntity): bool
    {
        $this->getPreResults("DELETE FROM `fields` WHERE `id` = :id;", [
            ':id' => $fieldEntity->getId()
        ]);
        return true;
    }
}
