<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use Danilocgsilva\Fieldsman\Entities\PayloadEntity;

use PDO;

class PayloadRepository implements RepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
        
    }
    
    /**
     * @return \Danilocgsilva\Fieldsman\Entities\PayloadEntity[]
     */
    public function all(): array
    {
        $query = "SELECT `name`, `content` FROM `payloads`;";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute();
        /** @var \Danilocgsilva\Fieldsman\Entities\PayloadEntity[] */
        $preResults->setFetchMode(PDO::FETCH_NUM);
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
        $query = "SELECT `name`, `content` FROM `payloads` WHERE id = :id;";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute([
            ':id' => $id
        ]);
        $preResults->setFetchMode(PDO::FETCH_NUM);
        $row = $preResults->fetch();
        
        return new PayloadEntity(
            $row[0],
            $row[1]
        );
    }

    public function update(int $id, PayloadEntity $payloadEntity): PayloadEntity
    {
        $query = "UPDATE `payloads` SET `name` = :name, `content` = :content WHERE `id` = :id;";
        $preResults = $this->pdo->prepare($query);
        $preResults->execute([
            ':name' => $payloadEntity->name,
            ':content' => $payloadEntity->content,
            ':id' => $payloadEntity->getId(),
        ]);
        return $payloadEntity;
    }

    public function store(PayloadEntity $payloadEntity): PayloadEntity
    {
        
    }

    public function destroy(PayloadEntity $payloadEntity): bool
    {
        
    }
}
