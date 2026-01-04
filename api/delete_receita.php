<?php
// api/delete_receita.php
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
    $stmt = $pdo->prepare("DELETE FROM receitas WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$id, $_SESSION['user_id']]);
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(['message' => 'Receita excluída']);
    } else {
        jsonResponse(['error' => 'Receita não encontrada ou permissão negada'], 404);
    }
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao excluir receita'], 500);
}
?>
