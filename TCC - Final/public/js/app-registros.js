document.addEventListener('DOMContentLoaded', () => {

    // --- Dados para preencher os selects (IDs do banco) ---
const categorias = [
    { value: '1', text: 'Crédito' },
    { value: '2', text: 'Débito' },
];


    const recorrencias = [
        { value: '1', text: 'Sem recorrência' },
        { value: '2', text: 'Diário' },
        { value: '3', text: 'Semanal' },
        { value: '4', text: 'Mensal' },
        { value: '5', text: 'Anual' }
    ];

    // --- Função para preencher selects ---
    const populateSelect = (id, options, defaultValue = '') => {
        const select = document.getElementById(id);
        if (!select) return;

        while (select.options.length > 1) {
            select.remove(1);
        }

        options.forEach(opt => {
            const o = document.createElement('option');
            o.value = opt.value;      // agora envia o ID numérico
            o.textContent = opt.text; // mostra o nome bonito
            select.appendChild(o);
        });

        if (defaultValue) select.value = defaultValue;
    };

    populateSelect('categoria', categorias);
    populateSelect('recorrencia', recorrencias, '1'); // default = "Sem recorrência"

    // --- Envio do formulário ---
    const form = document.getElementById('debito-form');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fd = new FormData(form);
            const recorrencia = (fd.get('recorrencia') || '').trim();

            if (!recorrencia) {
                showMessage('O campo Recorrência é obrigatório.', 'error');
                return;
            }

            try {
                const response = await fetch('../api/registro/process-registro.php', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: fd
                });

                let result;
                try {
                    result = await response.json();
                } catch (error) {
                    showMessage('Resposta inesperada do servidor.', 'error');
                    return;
                }

                if (result.success) {
                    showMessage(result.message || 'Registro adicionado com sucesso.', 'success');
                    form.reset();
                    document.getElementById('recorrencia').value = '1'; // volta para "Sem recorrência"
                    document.getElementById('valor').value = '0.00';
                } else {
                    showMessage(result.message || 'Erro ao salvar registro.', 'error');
                }

            } catch (error) {
                showMessage('Erro de conexão. Tente novamente.', 'error');
            }
        });

        // Botão limpar
        const limparBtn = document.getElementById('limpar-button');
        if (limparBtn) {
            limparBtn.addEventListener('click', () => {
                form.reset();
                document.getElementById('recorrencia').value = '1';
                document.getElementById('valor').value = '0.00';

                const msg = document.getElementById('registro-msg');
                if (msg) msg.style.display = 'none';
            });
        }
    }

    // --- Função de mensagens ---
    function showMessage(message, type = "success") {
        const msg = document.getElementById('registro-msg');
        if (!msg) return;

        msg.style.display = 'block';
        msg.textContent = message;

        if (type === "success") {
            msg.style.background = "#d4edda";
            msg.style.color = "#155724";
            msg.style.border = "1px solid #c3e6cb";
        } else {
            msg.style.background = "#f8d7da";
            msg.style.color = "#721c24";
            msg.style.border = "1px solid #f5c6cb";
        }

        setTimeout(() => msg.style.display = 'none', 3500);
    }
});
