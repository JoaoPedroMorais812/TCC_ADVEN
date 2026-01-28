// app-suporte.js
(() => {

    document.addEventListener("DOMContentLoaded", () => {

        // Seleciona todos os cards
        const cards = document.querySelectorAll(".problem-card");

        cards.forEach(card => {
            card.addEventListener("click", () => {
                const tipo = card.dataset.problemType;
                enviarEmail(tipo);
            });
        });

        // FAQ
        initFAQ();
    });

    // ==========================
    // ENVIAR EMAIL
    // ==========================
    function enviarEmail(tipo) {

        const formData = new FormData();
        formData.append("tipo", tipo);

        fetch("Php/sendhelp.php", {
            method: "POST",
            body: formData
        })
            .then(r => r.json())
            .then(json => {
                if (json.status === "success") {
                    alert("✔ Seu relatório foi enviado com sucesso!");
                } else {
                    alert("❌ Erro ao enviar: " + json.msg);
                }
            })
            .catch(err => {
                alert("❌ Falha de comunicação: " + err.message);
            });
    }

    // ==========================
    // FAQ Toggle
    // ==========================
    function initFAQ() {
        const faqList = document.getElementById("faq-list");

        const perguntas = [
            { q: "O sistema está lento, o que fazer?", a: "Tente limpar o cache e recarregar a página." },
            { q: "Meu registro não aparece, por quê?", a: "Pode ser sincronização. Verifique sua conexão." },
            { q: "Como recuperar minha senha?", a: "Use a opção 'Esqueci minha senha' na tela de login." }
        ];

        perguntas.forEach(item => {
            const div = document.createElement("div");
            div.classList.add("faq-item");
            div.innerHTML = `
                <button class="faq-question">
                    ${item.q}
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="faq-answer">${item.a}</div>
            `;
            faqList.appendChild(div);

            div.querySelector(".faq-question").addEventListener("click", () => {
                div.classList.toggle("active");
            });
        });
    }

})();
