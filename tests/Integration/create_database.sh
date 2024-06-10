#!/bin/bash

mysql -u$FIELDSMAN_TEST_DB_USER -p$FIELDSMAN_TEST_DB_PASSWORD -h$FIELDSMAN_TEST_DB_HOST <<EOF
CREATE DATABASE IF NOT EXISTS fieldsman_test;
USE fieldsman_test;

CREATE TABLE IF NOT EXISTS payloads (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    content TEXT
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS fields (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS field_payload (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    field_id INT UNSIGNED,
    payload_id INT UNSIGNED
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE field_payload ADD CONSTRAINT \`field_payload_field_constaint\` FOREIGN KEY (\`field_id\`) REFERENCES fields (\`id\`);
ALTER TABLE field_payload ADD CONSTRAINT \`field_payload_payload_constaint\` FOREIGN KEY (\`payload_id\`) REFERENCES payloads (\`id\`);

EOF
