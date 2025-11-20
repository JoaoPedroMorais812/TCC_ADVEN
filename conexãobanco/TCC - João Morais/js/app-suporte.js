document.addEventListener('DOMContentLoaded', () => {
    const faqs = [
        {
            question: "Como faço para recuperar minha senha?",
            answer: "Clique em 'Esqueceu sua senha?' na tela de login e siga as instruções enviadas para seu email."
        },
        {
            question: "Posso usar o sistema em múltiplos dispositivos?",
            answer: "Sim, você pode acessar sua conta de qualquer dispositivo conectado à internet."
        },
        {
            question: "Como exportar meus dados?",
            answer: "Na seção de Receitas, clique no botão 'Exportar' para baixar seus dados em formato CSV ou PDF."
        },
        {
            question: "O sistema funciona offline?",
            answer: "O Adven requer conexão com a internet para sincronizar seus dados em tempo real."
        }
    ];

    const populateFaqs = () => {
        const faqListContainer = document.getElementById('faq-list');
        if (!faqListContainer) return;

        faqs.forEach((faq) => {
            const faqItem = document.createElement('div');
            faqItem.classList.add('faq-item');
            faqItem.innerHTML = `
                <button class="faq-question">
                    <span>${faq.question}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>${faq.answer}</p>
                </div>
            `;
            faqListContainer.appendChild(faqItem);

            const questionButton = faqItem.querySelector('.faq-question');
            const answerContent = faqItem.querySelector('.faq-answer');

            questionButton.addEventListener('click', () => {
                faqItem.classList.toggle('active');
            });
        });
    };

    populateFaqs();
});
