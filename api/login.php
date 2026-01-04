<?php
// api/login.php
require_once '../src/db.php';
require_once '../src/utils.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Método inválido'], 405);
}

$input = getJsonInput();
$email = sanitize($input['email'] ?? '');
$senha = $input['senha'] ?? '';

if (empty($email) || empty($senha)) {
    jsonResponse(['error' => 'Preencha todos os campos'], 400);
}

$stmt = $pdo->prepare("SELECT id, nome, senha_hash, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['role'] = $user['role'];
    jsonResponse(['message' => 'Login com sucesso', 'redirect' => 'dashboard.php']);
} else {
    jsonResponse(['error' => 'Credenciais inválidas'], 401);
}
?>
