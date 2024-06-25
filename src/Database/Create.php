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

        $fieldsTableScriptSpitter = $this->getTableScriptSpitterfields();

        $fieldsPayloadTableScriptSpitter = $this->getTableScriptSpitterFieldPayload();
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
                (new FieldScriptSpitter("name"))
                    ->setType("VARCHAR(255)")
            )
            ->addField(
                (new FieldScriptSpitter("content"))
                    ->setType("TEXT")
            )
            ->setCharSet("utf8mb4")
            ->setCollateSuffix("general_ci");
    }

    private function getTableScriptSpitterfields(): TableScriptSpitter
    {
        return (new TableScriptSpitter("fields"))
            ->createIfNotExists()
            ->addField(
                (new FieldScriptSpitter("id"))
                    ->setUnsigned()
                    ->setNotNull()
                    ->setAutoIncrement()
                    ->setPrimaryKey()
                    ->setType("INT")
            )
            ->addField(
                (new FieldScriptSpitter("name"))
                    ->setType("VARCHAR(255)")
            )
            ->setCharSet("utf8mb4")
            ->setCollateSuffix("general_ci");
    }

    private function getTableScriptSpitterFieldPayload(): TableScriptSpitter
    {
        return (new TableScriptSpitter("field_payload"))
            ->createIfNotExists()
            ->addField(
                (new FieldScriptSpitter("id"))
                    ->setUnsigned()
                    ->setNotNull()
                    ->setAutoIncrement()
                    ->setPrimaryKey()
                    ->setType("INT")
            )
            ->addField(
                (new FieldScriptSpitter("field_id"))
                    ->setType("INT")
                    ->setUnsigned()
                    ->setNotNull()
            )
            ->addField(
                (new FieldScriptSpitter("payload_id"))
                    ->setType("INT")
                    ->setUnsigned()
                    ->setNotNull()
            )
            ->setCharSet("utf8mb4")
            ->setCollateSuffix("general_ci");;
    }
}
