<?php

require_once '../config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    $sql = file_get_contents('create_tables.sql');
    $db->exec($sql);
    echo "Tabelas criadas com sucesso.\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage() . "\n";
}

?>