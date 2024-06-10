<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;

use PDO;

class PayloadRepository extends AbstractRepository
{
    /**
     * @return \Danilocgsilva\Fieldsman\Entities\PayloadEntity[]
     */
    public function all(): array
    {
        $preResults = $this->getPreResults("SELECT `name`, `content` FROM `payloads`;");

        /** @var \Danilocgsilva\Fieldsman\Entities\PayloadEntity[] */
        $results = [];
        while ($row = $preResults->fetch()) {
            $results[] = new PayloadEntity(
                $row[0],
                $row[1]
            );
        }
        return $results;
    }

    public function getById(int $id): PayloadEntity
    {
        $preResults = $this->getPreResults("SELECT `name`, `content` FROM `payloads` WHERE id = :id;", [
            ':id' => $id
        ]);

        $row = $preResults->fetch();

        return new PayloadEntity(
            $row[0],
            $row[1]
        );
    }

    public function update(int $id, PayloadEntity $payloadEntity): PayloadEntity
    {
        $this->getPreResults("UPDATE `payloads` SET `name` = :name, `content` = :content WHERE `id` = :id;", [
            ':name' => $payloadEntity->name,
            ':content' => $payloadEntity->content,
            ':id' => $id,
        ]);

        return $payloadEntity;
    }

    public function store(PayloadEntity $payloadEntity): PayloadEntity
    {
        $query = "INSERT INTO `payloads` (`name`, `content`) VALUES (:name, :content);";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute([
            ':name' => $payloadEntity->name,
            ':content' => $payloadEntity->content
        ]);
        return $payloadEntity;
    }

    public function destroy(PayloadEntity $payloadEntity): bool
    {
        $this->getPreResults("DELETE FROM `payloads` WHERE `id` = :id;", [
            ':id' => $payloadEntity->getId()
        ]);
        return true;
    }
}
