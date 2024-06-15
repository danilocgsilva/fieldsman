<?php

declare(strict_types=1);

namespace Danilocgsilva\Fieldsman\Database;

use Danilocgsilva\ClassToSqlSchemaScript\TableScriptSpitter;
use Danilocgsilva\ClassToSqlSchemaScript\DatabaseScriptSpitter;
use Danilocgsilva\ClassToSqlSchemaScript\FieldScriptSpitter;
use PDO;

class Create
{
    public function create(string $databaseName): void
    {
        $databaseScriptSpitter = $this->getDatabaseScriptSpitter($databaseName);

        $payloadTableScriptSpitter = $this->getTableScriptSpitterPayloads();
    }

    private function getDatabaseScriptSpitter(string $databaseName): DatabaseScriptSpitter
    {
        return (new DatabaseScriptSpitter($databaseName))
            ->setIfNotExists()
            ->setUseSelf();
    }

    private function getTableScriptSpitterPayloads(): TableScriptSpitter
    {
        return (new TableScriptSpitter("payloads"))
            ->createIfNotExists()
            ->addField(
                (new FieldScriptSpitter("id"))
                    ->setNotNull()
                    ->setPrimaryKey()
                    ->setUnsigned()
                    ->setType("INT")
                    ->setAutoIncrement()
            )
            ->addField(
                (new FieldScriptSpitter("content"))
                    ->setType("TEXT")
            )
            ->addField(
                (new FieldScriptSpitter("content"))
                    ->setType("TEXT")
            );
    }
}
