<?php
// api/delete_despesa.php
require_once '../src/db.php';
require_once '../src/utils.php';
require_once '../src/auth.php';

apiAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Método inválido'], 405);
}

$input = getJsonInput();
$id = intval($input['id'] ?? 0);

if ($id <= 0) {
    jsonResponse(['error' => 'ID inválido'], 400);
}

try {
    $stmt = $pdo->prepare("DELETE FROM despesas WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$id, $_SESSION['user_id']]);
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(['message' => 'Despesa excluída']);
    } else {
        jsonResponse(['error' => 'Despesa não encontrada ou permissão negada'], 404);
    }
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao excluir despesa'], 500);
}
?>
