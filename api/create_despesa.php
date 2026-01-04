<?php
// api/create_despesa.php
require_once '../src/db.php';
require_once '../src/utils.php';
require_once '../src/auth.php';

apiAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Método inválido'], 405);
}

$input = getJsonInput();
$descricao = sanitize($input['descricao'] ?? '');
$valor = floatval($input['valor'] ?? 0);
$categoria = sanitize($input['categoria'] ?? '');
$data = sanitize($input['data'] ?? '');

if (empty($descricao) || $valor <= 0 || empty($categoria) || empty($data)) {
    jsonResponse(['error' => 'Dados inválidos'], 400);
}

try {
    $stmt = $pdo->prepare("INSERT INTO despesas (user_id, descricao, valor, categoria, data) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $descricao, $valor, $categoria, $data]);
    jsonResponse(['message' => 'Despesa criada com sucesso'], 201);
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao criar despesa'], 500);
}
?>
