<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - financeiro MPenha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2563eb">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-700">
        <div class="text-center mb-8">
            <img src="assets/logo.svg" alt="Logo" class="w-16 h-16 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-blue-500">IAFinance</h1>
            <p class="text-gray-400">Gerencie suas finanças</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                <input type="email" id="email" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="seu@email.com" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Senha</label>
                <input type="password" id="senha" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="••••••••" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center text-gray-400">
            Não tem uma conta? <a href="register.php" class="text-blue-500 hover:text-blue-400">Cadastre-se</a>
        </p>
        <div id="msg" class="mt-4 text-center text-sm font-medium hidden"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const msg = document.getElementById('msg');
            
            try {
                const res = await fetch('api/login.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({email, senha})
                });
                const data = await res.json();
                
                if (res.ok) {
                    msg.textContent = 'Login realizado! Redirecionando...';
                    msg.className = 'mt-4 text-center text-sm font-medium text-green-500 block';
                    setTimeout(() => window.location.href = data.redirect, 1000);
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

    
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('service-worker.js')
                .then(reg => console.log('SW Registered'))
                .catch(err => console.log('SW Error', err));
        }
    </script>
</body>
</html>
