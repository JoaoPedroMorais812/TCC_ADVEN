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

            // Validação local: recorrência obrigatória
            const fd = new FormData(debitoForm);
            const recorrCheck = (fd.get('recorrencia') || '').toString().trim();
            if (!recorrCheck) {
                const msgElLocal = document.getElementById('registro-msg');
                if (msgElLocal) {
                    msgElLocal.style.display = 'block';
                    msgElLocal.style.color = '#8b0000';
                    msgElLocal.textContent = 'O campo Recorrência é obrigatório.';
                } else {
                    showAlert('O campo Recorrência é obrigatório.', 'error');
                }
                return; // não prosseguir com envio
            }

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
                    showAlert('Resposta inesperada do servidor.', 'error');
                    return; // não processa mais
                }
                console.log('Resposta do servidor:', result);

                const msgEl = document.getElementById('registro-msg');
                const listBody = document.querySelector('#registro-list tbody');

                if (result.success) {
                    // mostra mensagem de sucesso
                    if (msgEl) {
                        // use registro-msg as semantic container, but visually use alert-box
                        msgEl.style.display = 'block';
                        msgEl.textContent = result.message || 'Registro adicionado com sucesso.';
                        msgEl.classList.remove('fade-out');
                        msgEl.classList.add('fade-in');
                    }
                    showAlert(result.message || 'Registro adicionado com sucesso.', 'success');

                    // se o backend retornou o id e/ou o record, insere na tabela dinamicamente
                    if (listBody) {
                        // ensure container is visible
                        const listContainer = document.getElementById('registro-list-container') || document.querySelector('#registro-list').closest('div');
                        if (listContainer) listContainer.style.display = 'block';
                        const id = result.id || '';
                        const rec = result.record || {};
                        const row = document.createElement('tr');
                        const nome = rec.reg_Nome || document.getElementById('nome-descricao')?.value || '';
                        const valor = rec.reg_Valor || document.getElementById('valor')?.value || '';
                        const data = rec.reg_Data || document.getElementById('data-vencimento')?.value || '';
                        const cat = rec.reg_idNatureza || document.getElementById('categoria')?.value || '';
                        const recorr = rec.reg_idRecorrencia || document.getElementById('recorrencia')?.value || '';
                        const obs = rec.reg_Descricao || document.getElementById('observacoes')?.value || '';
                        row.innerHTML = `<td style="padding:6px">${escapeHtml(id)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(nome)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(valor)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(data)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(cat)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(recorr)}</td>` +
                                        `<td style="padding:6px">${escapeHtml(obs)}</td>`;
                        listBody.insertBefore(row, listBody.firstChild);
                    }

                    debitoForm.reset(); // Limpa o formulário após o sucesso

                    // limpa mensagem após alguns segundos (fade out)
                    setTimeout(() => {
                        if (msgEl) {
                            msgEl.classList.remove('fade-in');
                            msgEl.classList.add('fade-out');
                            setTimeout(() => { msgEl.style.display = 'none'; msgEl.textContent = ''; }, 250);
                        }
                    }, 4000);
                } else {
                    if (msgEl) {
                        msgEl.style.display = 'block';
                        msgEl.style.color = '#8b0000';
                        const detailed = result.error ? ' Detalhes: ' + result.error : '';
                        msgEl.textContent = (result.message || 'Erro ao salvar.') + detailed;
                    } else {
                        showAlert(result.message || 'Erro ao salvar.', 'error');
                    }
                }

            } catch (error) {
                console.error('Erro ao enviar o formulário:', error);
                showAlert('Ocorreu um erro de conexão. Tente novamente.', 'error');
            }
        });
        // botão limpar: reseta o formulário e esconde mensagens
        const limparBtn = document.getElementById('limpar-button');
        if (limparBtn) {
            limparBtn.addEventListener('click', () => {
                // Reset native form first
                debitoForm.reset();

                // Ensure specific defaults
                const categoria = document.getElementById('categoria');
                if (categoria) categoria.value = '';
                const recorrencia = document.getElementById('recorrencia');
                if (recorrencia) recorrencia.value = 'sem-recorrencia';
                const status = document.getElementById('status');
                if (status) status.value = 'pendente';
                const valor = document.getElementById('valor');
                if (valor) valor.value = '0.00';

                // Clear inline messages and alert box
                const msgEl = document.getElementById('registro-msg');
                if (msgEl) {
                    msgEl.style.display = 'none';
                    msgEl.textContent = '';
                    msgEl.style.color = '';
                }
                const alertBox = document.getElementById('alert-box');
                if (alertBox) {
                    alertBox.style.display = 'none';
                    alertBox.textContent = '';
                    alertBox.style.background = '';
                    alertBox.style.color = '';
                    alertBox.style.border = '';
                }

                // Clear dynamic list
                const listBody = document.querySelector('#registro-list tbody');
                if (listBody) listBody.innerHTML = '';
                const listContainer = document.getElementById('registro-list-container');
                if (listContainer) listContainer.style.display = 'none';

                // Remove any validation error outlines
                const invalids = debitoForm.querySelectorAll('.is-invalid');
                invalids.forEach(el => el.classList.remove('is-invalid'));

                // Focus first field
                document.getElementById('nome-descricao')?.focus();
            });
        }
    }

    // utilitário simples para evitar XSS ao inserir HTML
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function showAlert(message, type = "success") {
        const box = document.getElementById('alert-box');

        if (!box) return;

        box.style.display = 'block';
        box.textContent = message;

        if (type === "success") {
            box.style.background = "#d4edda";
            box.style.color = "#155724";
            box.style.border = "1px solid #c3e6cb";
        } else if (type === "error") {
            box.style.background = "#f8d7da";
            box.style.color = "#721c24";
            box.style.border = "1px solid #f5c6cb";
        }

        // some após alguns segundos
        setTimeout(() => {
            box.style.display = 'none';
        }, 4000);
    }
});
