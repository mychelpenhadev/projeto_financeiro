<?php
require_once 'src/db.php';

$nome = 'Administrador';
$email = 'admin@iafinance.com';
$senha = 'admin123';
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$role = 'admin';

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "Usuário admin já existe! <br>";
        echo "Email: $email <br>";
        echo "Senha: $senha <br>";
        echo "<a href='index.php'>Ir para Login</a>";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (nome, email, senha_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha_hash, $role]);

    echo "Usuário Admin criado com sucesso! <br>";
    echo "Email: $email <br>";
    echo "Senha: $senha <br>";
    echo "<a href='index.php'>Ir para Login</a>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
