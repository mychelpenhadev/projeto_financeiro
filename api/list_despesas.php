<?php
// api/list_despesas.php
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
    $stmt = $pdo->prepare("SELECT * FROM despesas WHERE $where ORDER BY data DESC");
    $stmt->execute($params);
    $despesas = $stmt->fetchAll();
    jsonResponse($despesas);
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao buscar despesas'], 500);
}
?>
