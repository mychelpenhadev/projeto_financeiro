<?php
require_once 'src/auth.php';
checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas - IAFinance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="theme-color" content="#1a202c">
</head>
<body class="bg-gray-900 text-white min-h-screen pb-24">
    <header class="bg-gray-800 p-4 sticky top-0 z-10 flex justify-between items-center shadow-lg">
        <h1 class="text-xl font-bold text-green-400">Receitas</h1>
        <button onclick="openModal()" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </header>

    <main class="p-4">
        
        <!-- Filtros -->
        <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
            <button onclick="filter('Todos')" class="px-4 py-2 bg-gray-800 rounded-full text-sm whitespace-nowrap active-filter border border-green-500 text-white">Todos</button>
            <button onclick="filter('Salário')" class="px-4 py-2 bg-gray-800 rounded-full text-sm whitespace-nowrap text-gray-400">Salário</button>
            <button onclick="filter('Investimento')" class="px-4 py-2 bg-gray-800 rounded-full text-sm whitespace-nowrap text-gray-400">Investimento</button>
            <button onclick="filter('Extra')" class="px-4 py-2 bg-gray-800 rounded-full text-sm whitespace-nowrap text-gray-400">Extra</button>
        </div>

        <!-- Lista -->
        <div id="list" class="space-y-3">
            <p class="text-center text-gray-500 mt-10">Carregando...</p>
        </div>
    </main>

    <!-- Adicionar Modal -->
    <div id="modal" class="fixed inset-0 bg-black/80 hidden z-50 flex items-end sm:items-center justify-center">
        <div class="bg-gray-800 w-full max-w-md p-6 rounded-t-2xl sm:rounded-2xl space-y-4 animate-slide-up">
            <h2 class="text-xl font-bold mb-4">Nova Receita</h2>
            <form id="formAdd" class="space-y-4">
                <input type="text" name="descricao" placeholder="Descrição" class="w-full bg-gray-700 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <div class="flex gap-2">
                    <input type="number" step="0.01" name="valor" placeholder="Valor (R$)" class="w-full bg-gray-700 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <input type="date" name="data" class="w-full bg-gray-700 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <select name="categoria" class="w-full bg-gray-700 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="Salário">Salário</option>
                    <option value="Investimento">Investimento</option>
                    <option value="Extra">Extra</option>
                    <option value="Outros">Outros</option>
                </select>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 py-3 rounded-xl font-bold shadow-lg">Salvar</button>
                <button type="button" onclick="closeModal()" class="w-full py-3 text-gray-400">Cancelar</button>
            </form>
        </div>
    </div>
   
    <!-- Navegação inferior -->
    <nav class="fixed bottom-0 w-full bg-gray-800 border-t border-gray-700 pb-safe flex justify-around items-center h-16 z-40">
        <a href="dashboard.php" class="flex flex-col items-center gap-1 text-gray-400 hover:text-white w-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs">Inicio</span>
        </a>
        <a href="receitas.php" class="flex flex-col items-center gap-1 text-green-500 w-full">
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
    </nav>

    <script>
        let allItems = [];

        async function loadItems() {
            const res = await fetch('api/list_receitas.php');
            allItems = await res.json();
            renderItems(allItems);
        }

        function renderItems(items) {
            const list = document.getElementById('list');
            if (items.length === 0) {
                list.innerHTML = '<p class="text-center text-gray-500 mt-10">Nenhuma receita encontrada.</p>';
                return;
            }
            list.innerHTML = items.map(item => `
                <div class="bg-gray-800 p-4 rounded-xl shadow flex justify-between items-center border-l-4 border-green-500">
                    <div>
                        <p class="font-bold text-lg">${item.descricao}</p>
                        <p class="text-sm text-gray-400">${item.categoria} • ${new Date(item.data).toLocaleDateString('pt-BR')}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-green-400 font-bold text-lg">+ R$ ${parseFloat(item.valor).toFixed(2)}</p>
                        <button onclick="deleteItem(${item.id})" class="text-red-400 text-xs mt-1 hover:text-red-300">Excluir</button>
                    </div>
                </div>
            `).join('');
        }

        function filter(cat) {
            
            document.querySelectorAll('button[onclick^="filter"]').forEach(btn => {
                btn.classList.remove('border', 'border-green-500', 'text-white');
                btn.classList.add('text-gray-400');
            });
            event.target.classList.remove('text-gray-400');
            event.target.classList.add('border', 'border-green-500', 'text-white');

            if (cat === 'Todos') {
                renderItems(allItems);
            } else {
                renderItems(allItems.filter(i => i.categoria === cat));
            }
        }

        function openModal() { document.getElementById('modal').classList.remove('hidden'); }
        function closeModal() { document.getElementById('modal').classList.add('hidden'); }

        document.getElementById('formAdd').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const res = await fetch('api/create_receita.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data)
                });
                if (res.ok) {
                    closeModal();
                    e.target.reset();
                    loadItems();
                } else {
                    alert('Erro ao criar');
                }
            } catch (err) { alert('Erro de conexão'); }
        });

        async function deleteItem(id) {
            if (!confirm('Excluir esta receita?')) return;
            try {
                const res = await fetch('api/delete_receita.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id})
                });
                if (res.ok) loadItems();
            } catch (err) { alert('Erro'); }
        }

        loadItems();
    </script>
</body>
</html>
