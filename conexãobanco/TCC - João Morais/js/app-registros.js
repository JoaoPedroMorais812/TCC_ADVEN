document.addEventListener('DOMContentLoaded', () => {

    // --- Dados para preencher os selects ---
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

    // --- Função para preencher selects ---
    const populateSelect = (id, options, defaultValue = '') => {
        const select = document.getElementById(id);
        if (!select) return;

        while (select.options.length > 1) {
            select.remove(1);
        }

        options.forEach(opt => {
            const o = document.createElement('option');
            o.value = opt.value;
            o.textContent = opt.text;
            select.appendChild(o);
        });

        if (defaultValue) select.value = defaultValue;
    };

    populateSelect('categoria', categorias);
    populateSelect('recorrencia', recorrencias, 'sem-recorrencia');

    // --- Envio do formulário ---
    const form = document.getElementById('debito-form');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fd = new FormData(form);
            const recorrencia = (fd.get('recorrencia') || '').trim();

            // Validação simples
            if (!recorrencia) {
                showMessage('O campo Recorrência é obrigatório.', 'error');
                return;
            }

            try {
                const response = await fetch('Php/process-registro.php', {
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
                document.getElementById('recorrencia').value = 'sem-recorrencia';
                document.getElementById('valor').value = '0.00';

                const msg = document.getElementById('registro-msg');
                if (msg) msg.style.display = 'none';
            });
        }
    }

    // --- Função de mensagens usando a div registro-msg ---
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
