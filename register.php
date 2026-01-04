<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - IAFinanceCRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="theme-color" content="#2563eb">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-700">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-500">Crie sua Conta</h1>
            <p class="text-gray-400">Comece a controlar suas finanças</p>
        </div>

        <form id="registerForm" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Nome</label>
                <input type="text" id="nome" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="Seu nome" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                <input type="email" id="email" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="seu@email.com" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Senha</label>
                <input type="password" id="senha" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="••••••••" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                Cadastrar
            </button>
        </form>

        <p class="mt-6 text-center text-gray-400">
            Já tem uma conta? <a href="index.php" class="text-blue-500 hover:text-blue-400">Faça login</a>
        </p>
        <div id="msg" class="mt-4 text-center text-sm font-medium hidden"></div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const nome = document.getElementById('nome').value;
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const msg = document.getElementById('msg');
            
            try {
                const res = await fetch('api/register.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({nome, email, senha})
                });
                const data = await res.json();
                
                if (res.ok) {
                    msg.textContent = 'Conta criada! Redirecionando para login...';
                    msg.className = 'mt-4 text-center text-sm font-medium text-green-500 block';
                    setTimeout(() => window.location.href = 'index.php', 2000);
                } else {
                    msg.textContent = data.error;
                    msg.className = 'mt-4 text-center text-sm font-medium text-red-500 block';
                }
            } catch (err) {
                console.error(err);
                msg.textContent = 'Erro de conexão';
                msg.className = 'mt-4 text-center text-sm font-medium text-red-500 block';
            }
        });
    </script>
</body>
</html>
