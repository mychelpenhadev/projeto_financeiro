<?php
require_once 'src/auth.php';
checkAdmin(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - IAFinance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="theme-color" content="#1a202c">
</head>
<body class="bg-gray-900 text-white min-h-screen pb-24">
    <header class="bg-gray-800 p-4 sticky top-0 z-10 flex justify-between items-center shadow-lg">
        <h1 class="text-xl font-bold text-blue-500">Gestão de Usuários</h1>
        <a href="dashboard.php" class="text-gray-400 hover:text-white">Voltar</a>
    </header>

    <main class="p-4">
        <div id="list" class="space-y-3">
            <p class="text-center text-gray-500 mt-10">Carregando...</p>
        </div>
    </main>

    <script>
        async function loadUsers() {
            try {
                const res = await fetch('api/list_usuarios.php');
                const users = await res.json();
                
                const list = document.getElementById('list');
                if (users.length === 0) {
                    list.innerHTML = '<p class="text-center text-gray-500">Nenhum usuário.</p>';
                } else {
                    list.innerHTML = users.map(user => `
                        <div class="bg-gray-800 p-4 rounded-xl shadow flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg">${user.nome}</p>
                                <p class="text-sm text-gray-400">${user.email}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-xs ${user.role === 'admin' ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-700 text-gray-400'}">
                                    ${user.role}
                                </span>
                            </div>
                        </div>
                    `).join('');
                }
            } catch (err) {
                console.error(err);
                document.getElementById('list').innerHTML = '<p class="text-center text-red-500">Erro ao carregar usuários (Restrito a Admins).</p>';
            }
        }
        loadUsers();
    </script>
</body>
</html>
