document.addEventListener('DOMContentLoaded', () => {
    // --- Dados das Perguntas Frequentes (FAQs) ---
    const faqs = [
        {
            question: "Como faço para recuperar minha senha?",
            answer: "Clique em \"Esqueceu sua senha?\" na tela de login e siga as instruções enviadas para seu email."
        },
        {
            question: "Posso usar o sistema em múltiplos dispositivos?",
            answer: "Sim, você pode acessar sua conta de qualquer dispositivo conectado à internet."
        },
        {
            question: "Como exportar meus dados?",
            answer: "Na seção de Receitas, clique no botão \"Exportar\" para baixar seus dados em formato CSV ou PDF."
        },
        {
            question: "O sistema funciona offline?",
            answer: "O FinanceControl requer conexão com a internet para sincronizar seus dados em tempo real."
        }
    ];

    // --- Função para preencher a lista de FAQs ---
    const populateFaqs = () => {
        const faqListContainer = document.getElementById('faq-list');
        if (!faqListContainer) return;

        faqs.forEach((faq, index) => {
            const faqItem = document.createElement('div');
            faqItem.classList.add('faq-item');
            faqItem.innerHTML = `
                <button class="faq-question">
                    <span>${faq.question}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            `;
            faqListContainer.appendChild(faqItem);

            // Adiciona event listener para cada pergunta
            const questionButton = faqItem.querySelector('.faq-question');
            const answerContent = faqItem.querySelector('.faq-answer');

            questionButton.addEventListener('click', () => {
                // Alterna a classe 'active' no botão e na resposta
                questionButton.classList.toggle('active');
                answerContent.classList.toggle('active');

                // Ajusta a altura da resposta para a transição suave
                if (answerContent.classList.contains('active')) {
                    answerContent.style.maxHeight = answerContent.scrollHeight + "px";
                } else {
                    answerContent.style.maxHeight = null; // Volta para 0
                }
            });
        });
    };

    // --- Lógica para os cartões de tipo de problema ---
    const problemCards = document.querySelectorAll('.problem-card');
    problemCards.forEach(card => {
        card.addEventListener('click', () => {
            const problemType = card.dataset.problemType;
            let message = '';
            switch (problemType) {
                case 'desempenho':
                    message = 'Você selecionou: Problemas de Desempenho. Por favor, detalhe o ocorrido.';
                    break;
                case 'conexao':
                    message = 'Você selecionou: Problemas de Conexão. Por favor, detalhe o ocorrido.';
                    break;
                case 'outros':
                    message = 'Você selecionou: Outros Problemas. Por favor, descreva sua dúvida ou sugestão.';
                    break;
                default:
                    message = 'Tipo de problema não reconhecido.';
            }
            alert(message); // Usando alert para simplificar. Em uma app real, seria um modal de formulário.
        });
    });

    // --- Chamada inicial para preencher as FAQs ---
    populateFaqs();
});