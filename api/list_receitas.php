<?php
// api/list_receitas.php
require_once '../src/db.php';
require_once '../src/utils.php';
require_once '../src/auth.php';

apiAuth();

$user_id = $_SESSION['user_id'];
$where = "user_id = ?";
$params = [$user_id];

if (!empty($_GET['categoria'])) {
    $where .= " AND categoria = ?";
    $params[] = $_GET['categoria'];
}

try {
    $stmt = $pdo->prepare("SELECT * FROM receitas WHERE $where ORDER BY data DESC");
    $stmt->execute($params);
    $receitas = $stmt->fetchAll();
    jsonResponse($receitas);
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao buscar receitas'], 500);
}
?>
