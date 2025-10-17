document.addEventListener('DOMContentLoaded', () => {
    // --- Dados para preencher os selects (hardcoded, pois não temos data.php para isso) ---
    const categorias = [
        { value: 'alimentacao', text: 'Alimentação' },
        { value: 'transporte', text: 'Transporte' },
        { value: 'moradia', text: 'Moradia' },
        { value: 'lazer', text: 'Lazer' },
        { value: 'saude', text: 'Saúde' },
        { value: 'educacao', text: 'Educação' },
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
                // Caminho atualizado para a pasta 'backend'
                const response = awaitfetch('process-registro.php',  {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json(); // Assume que o PHP retorna JSON
                console.log('Resposta do servidor:', result);

                if (result.success) {
                    alert('Débito adicionado com sucesso!'); // Usando alert para simplificar, mas idealmente seria um modal customizado
                    debitoForm.reset(); // Limpa o formulário após o sucesso
                    // Opcional: recarregar ou atualizar uma lista de débitos aqui
                } else {
                    alert('Erro ao adicionar débito: ' + (result.message || 'Erro desconhecido.'));
                }

            } catch (error) {
                console.error('Erro ao enviar o formulário:', error);
                alert('Ocorreu um erro de conexão. Tente novamente.');
            }
        });
    }
});
