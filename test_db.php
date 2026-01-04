<?php
// test_db.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'src/db.php';

try {
    echo "Testando conexão...<br>";
    if ($pdo) {
        echo "Conexão bem sucedida!<br>";
        $stmt = $pdo->query("SELECT count(*) as total FROM users");
        $row = $stmt->fetch();
        echo "Total de usuários: " . $row['total'];
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
