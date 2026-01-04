<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MPenha Finance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#0f172a">
    <style>
        body {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .input-field {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(51, 65, 85, 0.5);
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #6366f1;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
            background: rgba(15, 23, 42, 0.8);
        }
        .btn-glow {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-glow:hover::before {
            left: 100%;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        }
        /* Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="text-white min-h-screen flex items-center justify-center p-4">
    
    <!-- Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/3 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl mix-blend-screen animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="w-full max-w-md glass-panel rounded-3xl p-8 relative overflow-hidden">
        <!-- Shine effect on top -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-50"></div>

        <div class="text-center mb-10 floating">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg mb-6 transform rotate-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400 tracking-tight">MPenha</h1>
            <p class="text-gray-400 text-sm mt-2">Financeiro do Futuro</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div class="space-y-1">
                <label class="block text-xs uppercase tracking-wider text-gray-400 font-semibold ml-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" class="input-field w-full rounded-xl pl-10 pr-4 py-3 placeholder-gray-600 text-white focus:outline-none" placeholder="admin@mpenha.com" required>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-xs uppercase tracking-wider text-gray-400 font-semibold ml-1">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="senha" class="input-field w-full rounded-xl pl-10 pr-4 py-3 placeholder-gray-600 text-white focus:outline-none" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-glow w-full py-4 rounded-xl text-white font-bold text-lg shadow-lg tracking-wide uppercase">
                Acessar Painel
            </button>
        </form>

        <p class="mt-8 text-center text-gray-500 text-sm">
            Não tem acesso? <a href="register.php" class="text-blue-400 hover:text-blue-300 transition-colors">Criar conta</a>
        </p>

        <div id="msg" class="mt-4 text-center text-sm font-medium hidden"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const msg = document.getElementById('msg');
            const btn = e.target.querySelector('button');
            
            // Animation state
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            try {
                const res = await fetch('api/login.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({email, senha})
                });
                const data = await res.json();
                
                if (res.ok) {
                    msg.innerHTML = '<span class="text-green-400">Acesso Permitido</span>';
                    msg.className = 'mt-4 text-center text-sm font-bold block animate-pulse';
                    setTimeout(() => window.location.href = data.redirect, 800);
                } else {
                    msg.innerHTML = `<span class="text-red-400">${data.error}</span>`;
                    msg.className = 'mt-4 text-center text-sm font-medium block shake';
                    btn.textContent = 'Acessar Painel';
                }
            } catch (err) {
                console.error(err);
                msg.textContent = 'Erro de conexão';
                msg.className = 'mt-4 text-center text-sm font-medium text-red-400 block';
                btn.textContent = 'Acessar Painel';
            }
        });

        // Register SW
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('service-worker.js');
        }
    </script>
</body>
</html>
