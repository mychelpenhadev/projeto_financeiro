<?php
require_once 'src/auth.php';
checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MPenha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#1a202c">
</head>
<body class="bg-gray-900 text-white min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-gray-800 p-4 shadow-lg sticky top-0 z-10 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="assets/logo.svg" class="w-8 h-8" alt="Logo">
            <h1 class="text-xl font-bold">Olá, <span id="userName"><?php echo htmlspecialchars($_SESSION['nome']); ?></span></h1>
        </div>
        <button onclick="logout()" class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </button>
    </header>

    <!-- Content -->
    <main class="p-4 space-y-6">
        <!-- Cards Resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border-l-4 border-green-500">
                <p class="text-gray-400 text-sm">Receitas</p>
                <p class="text-2xl font-bold text-green-400" id="totalReceitas">R$ 0,00</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border-l-4 border-red-500">
                <p class="text-gray-400 text-sm">Despesas</p>
                <p class="text-2xl font-bold text-red-400" id="totalDespesas">R$ 0,00</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg border-l-4 border-blue-500">
                <p class="text-gray-400 text-sm">Balanço</p>
                <p class="text-2xl font-bold text-gray-100" id="totalBalanco">R$ 0,00</p>
                <span id="badgeStatus" class="inline-block mt-2 px-2 py-1 text-xs rounded-full bg-gray-700 text-gray-300">Analisando...</span>
            </div>
        </div>

        <!-- Atalhos -->
        <div class="grid grid-cols-2 gap-4">
            <a href="receitas.php" class="bg-green-600/20 hover:bg-green-600/30 p-4 rounded-xl flex flex-col items-center justify-center gap-2 text-green-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-medium">Nova Receita</span>
            </a>
            <a href="despesas.php" class="bg-red-600/20 hover:bg-red-600/30 p-4 rounded-xl flex flex-col items-center justify-center gap-2 text-red-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
                <span class="font-medium">Nova Despesa</span>
            </a>
        </div>

        <!-- Chart -->
        <div class="bg-gray-800 p-4 rounded-2xl shadow-lg">
            <h2 class="text-lg font-bold mb-4">Fluxo Mensal</h2>
            <div class="relative h-64 w-full">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <!-- Transações recentes -->
        <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold">Lançamentos</h2>
                    <!-- Month Selector -->
                    <div class="flex items-center gap-2 bg-gray-700 rounded-lg p-1">
                        <button onclick="changeMonth(-1)" class="p-1 hover:bg-gray-600 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <span id="currentMonthLabel" class="text-sm font-medium w-32 text-center select-none">Mês Atual</span>
                        <button onclick="changeMonth(1)" class="p-1 hover:bg-gray-600 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div id="recentList" class="divide-y divide-gray-700 max-h-96 overflow-y-auto">
                <p class="p-4 text-center text-gray-500">Carregando...</p>
            </div>
        </div>
    </main>

    <!-- Navegação inferior -->
    <nav class="fixed bottom-0 w-full bg-gray-800 border-t border-gray-700 pb-safe flex justify-around items-center h-16 z-50">
        <a href="dashboard.php" class="flex flex-col items-center gap-1 text-blue-500 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs">Home</span>
        </a>
        <a href="receitas.php" class="flex flex-col items-center gap-1 text-gray-400 hover:text-white w-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
            </svg>
            <span class="text-xs">Receitas</span>
        </a>
        <a href="despesas.php" class="flex flex-col items-center gap-1 text-gray-400 hover:text-white w-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
            </svg>
            <span class="text-xs">Despesas</span>
        </a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="usuarios.php" class="flex flex-col items-center gap-1 text-gray-400 hover:text-white w-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-xs">Usuários</span>
        </a>
        <?php endif; ?>
    </nav>

    <script>
        let currentDate = new Date();
        let allTransactions = [];
        let financeChart = null;

        function formatMoney(value) {
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
        }

        function getMonthName(date) {
            return date.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
        }

        function changeMonth(delta) {
            currentDate.setMonth(currentDate.getMonth() + delta);
            updateDashboard();
        }

        async function loadData() {
            try {
                const [resRec, resDes] = await Promise.all([
                    fetch('api/list_receitas.php'),
                    fetch('api/list_despesas.php')
                ]);
                
                const receitas = await resRec.json();
                const despesas = await resDes.json();

                allTransactions = [
                    ...receitas.map(r => ({...r, type: 'receita', dateObj: new Date(r.data)})),
                    ...despesas.map(d => ({...d, type: 'despesa', dateObj: new Date(d.data)}))
                ];

                updateDashboard();

            } catch (err) {
                console.error(err);
            }
        }

        function updateDashboard() {
            // Atualizar etiqueta do mês
            const label = document.getElementById('currentMonthLabel');
            label.textContent = getMonthName(currentDate); // e.g. "janeiro de 2026"
            label.className = "text-sm font-medium w-40 text-center select-none capitalize"; // Add capitalize

            // Filtrar por mês
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            const filtered = allTransactions.filter(t => 
                t.dateObj.getMonth() === currentMonth && 
                t.dateObj.getFullYear() === currentYear
            );

            // Calcular os totais do mês
            const totalReceitas = filtered.filter(t => t.type === 'receita').reduce((acc, t) => acc + parseFloat(t.valor), 0);
            const totalDespesas = filtered.filter(t => t.type === 'despesa').reduce((acc, t) => acc + parseFloat(t.valor), 0);
            const balanco = totalReceitas - totalDespesas;

            // Atualizar cartões
            document.getElementById('totalReceitas').textContent = formatMoney(totalReceitas);
            document.getElementById('totalDespesas').textContent = formatMoney(totalDespesas);
            const balancoEl = document.getElementById('totalBalanco');
            balancoEl.textContent = formatMoney(balanco);
            balancoEl.className = `text-2xl font-bold ${balanco >= 0 ? 'text-green-400' : 'text-red-400'}`;

            const badge = document.getElementById('badgeStatus');
            if (balanco >= 0) {
                badge.textContent = 'Empresa Positiva';
                badge.className = 'inline-block mt-2 px-2 py-1 text-xs rounded-full bg-green-900 text-green-300';
            } else {
                badge.textContent = 'Empresa no Vermelho';
                badge.className = 'inline-block mt-2 px-2 py-1 text-xs rounded-full bg-red-900 text-red-300';
            }

            // Atualizar lista
            // Ordenado por data decrescente
            const sortedList = filtered.sort((a, b) => b.dateObj - a.dateObj);
            const listEl = document.getElementById('recentList');
            
            if (sortedList.length === 0) {
                listEl.innerHTML = '<p class="p-4 text-center text-gray-500">Nenhuma movimentação neste mês.</p>';
            } else {
                listEl.innerHTML = sortedList.map(t => `
                    <div class="p-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg ${t.type === 'receita' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500'}">
                                ${t.type === 'receita' 
                                    ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>'
                                    : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>'
                                }
                            </div>
                            <div>
                                <p class="font-medium">${t.descricao}</p>
                                <p class="text-xs text-gray-500">${t.dateObj.toLocaleDateString('pt-BR')}</p>
                            </div>
                        </div>
                        <span class="font-bold ${t.type === 'receita' ? 'text-green-400' : 'text-red-400'}">
                            ${t.type === 'receita' ? '+' : '-'} ${formatMoney(t.valor)}
                        </span>
                    </div>
                `).join('');
            }

            // Atualizar gráfico
            renderChart(totalReceitas, totalDespesas);
        }

        function renderChart(receitas, despesas) {
            const ctx = document.getElementById('financeChart').getContext('2d');
            
            if (financeChart) {
                financeChart.destroy();
            }

            financeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Receitas', 'Despesas'],
                    datasets: [{
                        data: [receitas, despesas],
                        backgroundColor: ['#22c55e', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { color: '#fff' } }
                    }
                }
            });
        }

        function logout() {
            window.location.href = 'logout.php';
        }

        loadData();
    </script>
</body>
</html>
