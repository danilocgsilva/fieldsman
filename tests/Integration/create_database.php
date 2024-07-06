<?php
use Danilocgsilva\ClassToSqlSchemaScript\TableScriptSpitter;

require("../../vendor/autoload.php");

use Danilocgsilva\ClassToSqlSchemaScript\{
    DatabaseScriptSpitter,
    FieldScriptSpitter,
    ForeignKeyScriptSpitter
};
use Tests\Integration\DatabaseTraits\UtilsTrait;

$databaseScriptSpitter = (new DatabaseScriptSpitter("fieldsman_test"))
    ->setIfNotExists()
    ->setUseSelf()
    ->addTableScriptSpitter(
        (new TableScriptSpitter("payloads"))
        ->createIfNotExists()
        ->setCharSet("utf8mb4")
        ->setCollateSuffix("general_ci")
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
        ->addField(
            (new FieldScriptSpitter("content"))
            ->setType("TEXT")
        )
    )
    ->addTableScriptSpitter(
        (new TableScriptSpitter("fields"))
        ->createIfNotExists()
        ->setCharSet("utf8mb4")
        ->setCollateSuffix("general_ci")
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
    )
    ->addTableScriptSpitter(
        (new TableScriptSpitter("field_payload"))
        ->createIfNotExists()
        ->setCharSet("utf8mb4")
        ->setCollateSuffix("general_ci")
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
            ->setNotNull()
            ->setUnsigned()
        )
        ->addField(
            (new FieldScriptSpitter("payload_id"))
            ->setType("INT")
            ->setNotNull()
            ->setUnsigned()
        )
    )
    ->addTableScriptSpitter(
        (new ForeignKeyScriptSpitter())
        ->setConstraintName("field_payload_field_constaint")
        ->setTable("field_payload")
        ->setForeignKey("field_id")
        ->setTableForeignkey("id")
        ->setForeignTable("fields")
    )
    ->addTableScriptSpitter(
        (new ForeignKeyScriptSpitter())
        ->setConstraintName("field_payload_payload_constaint")
        ->setTable("field_payload")
        ->setForeignKey("payload_id")
        ->setTableForeignkey("id")
        ->setForeignTable("payloads")
    );

$pdo = ($pdoGenerator = new class()
{
    use UtilsTrait;
})->getPdo();

$preresults = $pdo->prepare($databaseScriptSpitter->getScript());
$preresults->execute();
