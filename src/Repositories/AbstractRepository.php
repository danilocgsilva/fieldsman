<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Repositories;

use PDO;

abstract class AbstractRepository
{
    public function __construct(protected PDO $pdo)
    {
    }

    protected function getPreResults($query, array $fields = [])
    {
        $preResults = $this->pdo->prepare($query);
        $preResults->execute($fields);
        $preResults->setFetchMode(PDO::FETCH_NUM);
        return $preResults;
    }

    protected function getLastId(): int
    {
        $preResults = $this->getPreResults("SELECT LAST_INSERT_ID();");
        return $preResults->fetch()[0];
    }
}
