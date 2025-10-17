document.addEventListener('DOMContentLoaded', () => {
    // Função para formatar valores como moeda brasileira (R$)
    const formatCurrency = (value) => {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    };

    // Função para atualizar os cartões de métricas
    const updateMetrics = (metrics) => {
        document.getElementById('total-receitas').textContent = formatCurrency(metrics.totalReceitas);
        document.getElementById('total-despesas').textContent = formatCurrency(metrics.totalDespesas);
        document.getElementById('saldo').textContent = formatCurrency(metrics.saldo);
        document.getElementById('previsoes').textContent = formatCurrency(metrics.previsoes);

        // Atualiza as porcentagens de mudança
        document.getElementById('total-receitas-change').textContent = metrics.changeReceitas;
        document.getElementById('total-despesas-change').textContent = metrics.changeDespesas;
        document.getElementById('saldo-change').textContent = metrics.changeSaldo;
        // A previsão de mudança já tem um texto fixo na imagem, então mantemos
        document.getElementById('previsoes-change').textContent = '2 contas a vencer';
    };

    // Função para atualizar o total de lançamentos na tabela
    const updateTotalInfo = (receitas) => {
        const total = receitas.reduce((sum, item) => sum + item.valor, 0);
        document.getElementById('total-lancamentos').textContent = `${receitas.length} lançamentos - Total ${formatCurrency(total)}`;
    };

    // Função para criar uma linha da tabela de receitas
    const createReceitaRow = (receita) => {
        const row = document.createElement('tr');
        // Adiciona classe de status se a recorrência for 'Cancelado'
        const statusClass = receita.recorrencia === 'Cancelado' ? 'status-cancelado' : '';

        row.innerHTML = `
            <td>${receita.data}</td>
            <td>${receita.conta}</td>
            <td>${receita.fonte}</td>
            <td>${formatCurrency(receita.valor)}</td>
            <td>
                <span class="${statusClass}">${receita.recorrencia}</span>
            </td>
            <td>
                <div class="actions">
                    <button><i class="fas fa-edit"></i></button>
                    <button><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
        `;
        return row;
    };

    // Função para preencher a tabela de receitas
    const updateReceitasTable = (receitas) => {
        const tbody = document.getElementById('table-content');
        tbody.innerHTML = ''; // Limpa o conteúdo existente
        receitas.forEach(receita => {
            tbody.appendChild(createReceitaRow(receita));
        });
        updateTotalInfo(receitas); // Atualiza o contador e total
    };

    // Função para criar um item da agenda financeira
    const createAgendaItem = (item) => {
        const div = document.createElement('div');
        div.classList.add('widget-item');
        div.innerHTML = `
            <div class="item-title">${item.titulo}</div>
            <div class="item-subtitle">${item.data}</div>
        `;
        return div;
    };

    // Função para preencher a agenda financeira
    const updateAgenda = (agenda) => {
        const container = document.getElementById('agenda-financeira');
        container.innerHTML = '';
        agenda.forEach(item => {
            container.appendChild(createAgendaItem(item));
        });
    };

    // Função para criar um item de notificação
    const createNotificationItem = (item) => {
        const div = document.createElement('div');
        div.classList.add('notificacoes-item');
        div.innerHTML = `
            <div class="item-title">${item.titulo}</div>
            <div class="item-subtitle">${item.mensagem}</div>
        `;
        return div;
    };

    // Função para preencher as notificações
    const updateNotificacoes = (notificacoes) => {
        const container = document.getElementById('notificacoes');
        container.innerHTML = '';
        notificacoes.forEach(item => {
            container.appendChild(createNotificationItem(item));
        });
        // Atualiza a contagem de notificações no cabeçalho do widget
        document.getElementById('notification-count').textContent = notificacoes.length;
    };

    // Função para criar um item de próximas saídas
    const createSaidaItem = (item) => {
        const div = document.createElement('div');
        div.classList.add('widget-item');
        div.innerHTML = `
            <div class="item-title">${item.titulo}</div>
            <div class="item-subtitle">${item.data}</div>
            <div class="item-valor">${formatCurrency(item.valor)}</div>
        `;
        return div;
    };

    // Função para preencher as próximas saídas
    const updateProximasSaidas = (saidas) => {
        const container = document.getElementById('proximas-saidas');
        container.innerHTML = '';
        saidas.forEach(item => {
            container.appendChild(createSaidaItem(item));
        });
    };

    // Função principal para buscar e renderizar todos os dados
    const fetchData = async () => {
        try {
            // Requisição ao seu script PHP (caminho atualizado para a pasta 'backend')
            const response = await fetch('data-notas.php');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Chama as funções para atualizar cada seção da página
            updateMetrics(data.metrics);
            updateReceitasTable(data.receitas);
            updateAgenda(data.agenda);
            updateNotificacoes(data.notificacoes);
            updateProximasSaidas(data.proximasSaidas);

            // Armazenar os dados originais para filtragem
            window.originalReceitasData = data.receitas;

        } catch (error) {
            console.error('Erro ao buscar os dados:', error);
            // Aqui você pode adicionar uma mensagem de erro na UI se desejar
        }
    };

    // Chama a função para carregar os dados assim que o DOM estiver pronto
    fetchData();

    // Exemplo de funcionalidade de pesquisa (apenas filtragem no frontend)
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            // Em uma aplicação real, você faria uma nova requisição ao backend com o termo de pesquisa
            // Para este exemplo, vamos apenas filtrar os dados existentes (não persistente)
            // Usa window.originalReceitasData para filtrar a partir dos dados completos
            const filteredReceitas = window.originalReceitasData.filter(receita =>
                receita.conta.toLowerCase().includes(searchTerm) ||
                receita.fonte.toLowerCase().includes(searchTerm)
            );
            updateReceitasTable(filteredReceitas);
        });
    }
});