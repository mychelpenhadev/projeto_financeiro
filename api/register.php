<?php
// api/register.php
require_once '../src/db.php';
require_once '../src/utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Método inválido'], 405);
}

$input = getJsonInput();
$nome = sanitize($input['nome'] ?? '');
$email = sanitize($input['email'] ?? '');
$senha = $input['senha'] ?? '';

if (empty($nome) || empty($email) || empty($senha)) {
    jsonResponse(['error' => 'Preencha todos os campos'], 400);
}


$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonResponse(['error' => 'Email já cadastrado'], 400);
}

$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (nome, email, senha_hash) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senha_hash]);
    jsonResponse(['message' => 'Usuário criado com sucesso'], 201);
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro ao criar usuário'], 500);
}
?>
