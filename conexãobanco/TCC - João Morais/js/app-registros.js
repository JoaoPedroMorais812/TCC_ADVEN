document.addEventListener('DOMContentLoaded', () => {
    // --- Dados para preencher os selects (hardcoded, pois não temos data.php para isso) ---
    const categorias = [
        { value: 'Debito', text: 'Débito' },
        { value: 'Credito', text: 'Crédito' },
        { value: 'outros', text: 'Outros' }
    ];

    const recorrencias = [
        { value: 'sem-recorrencia', text: 'Sem recorrência' },
        { value: 'diario', text: 'Diário' },
        { value: 'semanal', text: 'Semanal' },
        { value: 'mensal', text: 'Mensal' },
        { value: 'anual', text: 'Anual' }
    ];

    const statusOptions = [
        { value: 'pendente', text: 'Pendente' },
        { value: 'pago', text: 'Pago' },
        { value: 'atrasado', text: 'Atrasado' },
        { value: 'cancelado', text: 'Cancelado' }
    ];

    // --- Funções de Preenchimento de Selects ---
    const populateSelect = (selectElementId, optionsArray, defaultValue = '') => {
        const select = document.getElementById(selectElementId);
        if (!select) return;

        // Limpa opções existentes, exceto a primeira (placeholder)
        while (select.options.length > (select.options[0]?.value === '' ? 1 : 0)) {
            select.remove(select.options.length - 1);
        }

        optionsArray.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.textContent = option.text;
            select.appendChild(opt);
        });

        // Define o valor padrão se fornecido
        if (defaultValue) {
            select.value = defaultValue;
        }
    };

    // --- Inicialização dos Selects ---
    populateSelect('categoria', categorias, ''); // O valor vazio já é o default
    populateSelect('recorrencia', recorrencias, 'sem-recorrencia');
    populateSelect('status', statusOptions, 'pendente');

    // --- Lógica de Troca de Abas ---
    const tabButtons = document.querySelectorAll('.tabs-navigation .tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'active' de todos os botões e conteúdos
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Adiciona 'active' ao botão clicado
            button.classList.add('active');

            // Mostra o conteúdo da aba correspondente
            const targetTabId = button.dataset.tab + '-tab-content';
            const targetTabContent = document.getElementById(targetTabId);
            if (targetTabContent) {
                targetTabContent.classList.add('active');
            }
        });
    });

    // --- Lógica de Envio do Formulário ---
    const debitoForm = document.getElementById('debito-form');
    if (debitoForm) {
        debitoForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(debitoForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            console.log('Dados do formulário a serem enviados:', data);

            try {
                // Envia como FormData para que o PHP preencha $_POST corretamente
                const fd = new FormData(debitoForm);
                const response = await fetch('Php/process-registro.php', {
                    method: 'POST',
                    headers: {
                        // informa ao backend que é uma requisição AJAX e que espera JSON
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: fd
                });

                let result;
                try {
                    result = await response.json(); // tenta parsear JSON
                } catch (err) {
                    // se não for JSON, tenta ler como texto para ajudar no debug
                    const text = await response.text();
                    console.error('Resposta não-JSON do servidor:', text);
                    throw new Error('Resposta inesperada do servidor');
                }
                console.log('Resposta do servidor:', result);

                const msgEl = document.getElementById('registro-msg');
                const listContainer = document.getElementById('registro-list-container');
                const listBody = document.querySelector('#registro-list tbody');

                if (result.success) {
                    // mostra mensagem de sucesso
                    if (msgEl) {
                        msgEl.style.display = 'block';
                        msgEl.style.color = '#0b6623';
                        msgEl.textContent = result.message || 'Registro adicionado com sucesso!';
                    }

                    // se o backend retornou o id e/ou o record, insere na tabela dinamicamente
                    if (listContainer && listBody) {
                        listContainer.style.display = 'block';
                        const id = result.id || '';
                        const rec = result.record || {};
                        const row = document.createElement('tr');
                        const nome = rec.reg_Nome || document.getElementById('nome-descricao')?.value || '';
                        const valor = rec.reg_Valor || document.getElementById('valor')?.value || '';
                        const data = rec.reg_Data || document.getElementById('data-vencimento')?.value || '';
                        const cat = rec.reg_idNatureza || document.getElementById('categoria')?.value || '';
                        row.innerHTML = `<td>${id}</td><td>${escapeHtml(nome)}</td><td>${escapeHtml(valor)}</td><td>${escapeHtml(data)}</td><td>${escapeHtml(cat)}</td>`;
                        listBody.insertBefore(row, listBody.firstChild);
                    }

                    debitoForm.reset(); // Limpa o formulário após o sucesso

                    // limpa mensagem após alguns segundos
                    setTimeout(() => { if (msgEl) msgEl.style.display = 'none'; }, 5000);
                } else {
                    if (msgEl) {
                        msgEl.style.display = 'block';
                        msgEl.style.color = '#8b0000';
                        const detailed = result.error ? ' Detalhes: ' + result.error : '';
                        msgEl.textContent = (result.message || 'Erro ao salvar.') + detailed;
                    } else {
                        alert(result.message || 'Erro ao salvar.');
                    }
                }

            } catch (error) {
                console.error('Erro ao enviar o formulário:', error);
                alert('Ocorreu um erro de conexão. Tente novamente.');
            }
        });
    }

    // utilitário simples para evitar XSS ao inserir HTML
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }
});
