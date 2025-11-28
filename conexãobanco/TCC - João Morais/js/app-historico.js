document.addEventListener('DOMContentLoaded', () => {

    // ---------------------------
    // FORMATAR MOEDA
    // ---------------------------
    const formatCurrency = (value) => {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    };

    // ---------------------------
    // ATUALIZAR TOTAL DA TABELA
    // ---------------------------
    const updateTotalInfo = (receitas) => {
        const total = receitas.reduce((sum, item) => sum + item.valor, 0);
        document.getElementById('total-lancamentos').textContent =
            `${receitas.length} lançamentos - Total ${formatCurrency(total)}`;
    };

    // ---------------------------
    // GERAR LINHA DA TABELA
    // ---------------------------
    const createReceitaRow = (receita) => {
        const row = document.createElement('tr');

        const statusClass = receita.recorrencia === 'Cancelado' ? 'status-cancelado' : '';

        row.innerHTML = `
            <td>${receita.data}</td>
            <td>${receita.conta}</td>
            <td>${receita.fonte}</td>
            <td>${formatCurrency(receita.valor)}</td>
            <td><span class="${statusClass}">${receita.recorrencia}</span></td>

            <td class="actions-edit">
                <button class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </button>
            </td>

            <td class="actions-delete">
                <button class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        return row;
    };

    // ---------------------------
    // ATUALIZAR TABELA
    // ---------------------------
    const updateReceitasTable = (receitas) => {
        const tbody = document.getElementById('table-content');
        tbody.innerHTML = '';

        receitas.forEach(receita => {
            tbody.appendChild(createReceitaRow(receita));
        });

        updateTotalInfo(receitas);
    };

    // ---------------------------
    // GERAR AGENDA
    // ---------------------------
    const createAgendaItem = (item) => {
        const div = document.createElement('div');
        div.classList.add('widget-item');
        div.innerHTML = `
            <div class="item-title">${item.titulo}</div>
            <div class="item-subtitle">${item.data}</div>
        `;
        return div;
    };

    const updateAgenda = (agenda) => {
        const container = document.getElementById('agenda-financeira');
        if (!container) return;

        container.innerHTML = '';

        agenda.forEach(item => {
            container.appendChild(createAgendaItem(item));
        });
    };

    // ---------------------------
    // NOTIFICAÇÕES
    // ---------------------------
    const createNotificationItem = (item) => {
        const div = document.createElement('div');
        div.classList.add('notificacoes-item');
        div.innerHTML = `
            <div class="item-title">${item.titulo}</div>
            <div class="item-subtitle">${item.mensagem}</div>
        `;
        return div;
    };

    const updateNotificacoes = (notificacoes) => {
        const container = document.getElementById('notificacoes');
        if (!container) return;

        container.innerHTML = '';

        notificacoes.forEach(item => {
            container.appendChild(createNotificationItem(item));
        });

        const badge = document.getElementById('notification-count');
        if (badge) badge.textContent = notificacoes.length;
    };

    // ---------------------------
    // PRÓXIMAS SAÍDAS
    // ---------------------------
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

    const updateProximasSaidas = (saidas) => {
        const container = document.getElementById('proximas-saidas');
        if (!container) return;

        container.innerHTML = '';

        saidas.forEach(item => container.appendChild(createSaidaItem(item)));
    };

    // ---------------------------
    // BUSCAR DADOS (NOVA URL)
    // ---------------------------
    const fetchData = async () => {
        try {
            const params = new URLSearchParams();

            const periodoEl = document.getElementById('filter-periodo');
            const fonteEl = document.getElementById('filter-fontes'); // CORRIGIDO
            const startEl = document.getElementById('filter-start');
            const endEl = document.getElementById('filter-end');

            if (periodoEl && periodoEl.value) params.set('periodo', periodoEl.value);
            if (fonteEl && fonteEl.value) params.set('fonte', fonteEl.value);
            if (startEl && startEl.value) params.set('start', startEl.value);
            if (endEl && endEl.value) params.set('end', endEl.value);

            const url =
                'process-historico.php' + (params.toString() ? ('?' + params.toString()) : '');

            const response = await fetch(url);
            const data = await response.json();

            updateReceitasTable(data.receitas);
            updateAgenda(data.agenda);
            updateNotificacoes(data.notificacoes);
            updateProximasSaidas(data.proximasSaidas);

            window.originalReceitasData = data.receitas;

        } catch (error) {
            console.error("Erro ao carregar dados:", error);
        }
    };

    // ---------------------------
    // FILTROS
    // ---------------------------
    ['filter-periodo', 'filter-fontes', 'filter-start', 'filter-end'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', fetchData);
    });

    // ---------------------------
    // PESQUISA
    // ---------------------------
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const termo = e.target.value.toLowerCase();

            if (!window.originalReceitasData) return;

            const filtradas = window.originalReceitasData.filter(receita =>
                receita.conta.toLowerCase().includes(termo) ||
                receita.fonte.toLowerCase().includes(termo)
            );

            updateReceitasTable(filtradas);
        });
    }

    // ---------------------------
    // INICIAR
    // ---------------------------
    fetchData();
});
