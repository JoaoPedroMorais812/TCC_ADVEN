document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });
  }

  // Carregar notificações da API
  async function carregarNotificacoes() {
    try {
      const res = await fetch("../api/Notificacoes/list.php"); // só lista
      const notificacoes = await res.json();

      const container = document.getElementById("listaNotificacoes");
      container.innerHTML = "";

      if (Array.isArray(notificacoes) && notificacoes.length > 0) {
        notificacoes.forEach(n => {
          const alerta = document.createElement("div");
          alerta.classList.add("alerta", "aviso");
          alerta.dataset.id = n.id;

          // classe por tipo (opcional)
          const classeTipo = {
            "Reunião": "azul",
            "Pagamento": "vermelho",
            "Entrega": "laranja",
            "Outro": "verde"
          }[n.tipo];
          if (classeTipo) alerta.classList.add(classeTipo);

          alerta.innerHTML = `
            <div class="icone"><i class="bi bi-bell"></i></div>
            <div class="conteudo">
              <strong>${n.titulo}</strong>
              <p>${n.data} às ${n.horario}</p>
              <span>Compromisso</span>
            </div>
            <div class="acoes">
              <i class="bi bi-check2" title="Marcar como lida"></i>
              <i class="bi bi-trash" title="Excluir"></i>
            </div>
          `;
          container.appendChild(alerta);
        });
      } else {
        container.innerHTML = "<p>📭 Nenhuma notificação</p>";
      }

      atualizarBadge();
      ativarAcoes();
    } catch (err) {
      console.error("Erro ao carregar notificações:", err);
    }
  }

  // Atualizar contador de notificações
  function atualizarBadge() {
    const total = document.querySelectorAll("#listaNotificacoes .alerta").length;
    const badgeTopo = document.getElementById("badge-topo");
    const badgeSidebar = document.querySelector('.nav-links .active .badge');

    if (badgeTopo) {
      if (total === 0) {
        badgeTopo.style.display = "none";
      } else {
        badgeTopo.style.display = "inline-block";
        badgeTopo.textContent = `${total} não lida${total > 1 ? "s" : ""}`;
      }
    }

    if (badgeSidebar) {
      badgeSidebar.textContent = total.toString();
    }
  }

  // Ativar ações dos botões (somente na tela)
  function ativarAcoes() {
    // marcar como lida
    document.querySelectorAll("#listaNotificacoes .alerta .bi-check2").forEach(btn => {
      btn.addEventListener("click", function () {
        const alerta = this.closest(".alerta");
        esconderERemover(alerta); // só remove da tela
      });
    });

    // excluir
    document.querySelectorAll("#listaNotificacoes .alerta .bi-trash").forEach(btn => {
      btn.addEventListener("click", function () {
        const alerta = this.closest(".alerta");
        esconderERemover(alerta); // só remove da tela
      });
    });

    // marcar todas como lidas
    const marcarTodas = document.getElementById("marcar-todas");
    if (marcarTodas) {
      marcarTodas.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelectorAll("#listaNotificacoes .alerta").forEach(alerta => esconderERemover(alerta));
      });
    }
  }

  // animação para remover
  function esconderERemover(el) {
    el.style.transition = "0.3s";
    el.style.opacity = "0";
    setTimeout(() => {
      el.remove();
      atualizarBadge();
    }, 300);
  }

  // inicializa carregando as notificações
  carregarNotificacoes();
});
