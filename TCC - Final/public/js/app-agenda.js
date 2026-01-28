// =====================
// CALENDÁRIO
// =====================
const calendarDays = document.getElementById("calendarDays");
const monthYear = document.getElementById("monthYear");
const selectedDate = document.getElementById("selectedDate");
const selectedList = document.getElementById("selectedList");

let currentDate = new Date();

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();

  monthYear.textContent = `${date.toLocaleString("pt-BR", { month: "long" })} ${year}`;
  calendarDays.innerHTML = "";

  for (let i = 0; i < firstDay; i++) {
    calendarDays.innerHTML += "<div></div>";
  }

  for (let d = 1; d <= lastDate; d++) {
    const isToday =
      d === new Date().getDate() &&
      month === new Date().getMonth() &&
      year === new Date().getFullYear();

    calendarDays.innerHTML += `
      <div class="${isToday ? "today" : ""}" onclick="selectDate(${year}, ${month}, ${d})">
        ${d}
      </div>`;
  }
}

function prevMonth() {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
}

function nextMonth() {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
}

function goToToday() {
  currentDate = new Date();
  renderCalendar(currentDate);
}

// =====================
// SELEÇÃO DE DIA
// =====================
function selectDate(y, m, d) {
  const date = new Date(y, m, d);
  const formatted = date.toLocaleDateString("pt-BR", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric",
  });

  selectedDate.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);

  // chama API para buscar compromissos do dia
  const dataISO = date.toISOString().split("T")[0]; // formato YYYY-MM-DD
  carregarCompromissosDoDia(dataISO);
}

renderCalendar(currentDate);

// =====================
// API: COMPROMISSOS DO DIA
// =====================
async function carregarCompromissosDoDia(dataSelecionada) {
  try {
    const res = await fetch("../api/Agenda/porData.php", {
      method: "POST",
      body: new URLSearchParams({ data: dataSelecionada })
    });
    const eventos = await res.json();

    selectedList.innerHTML = "";

    if (!eventos || eventos.length === 0) {
      selectedList.textContent = "Nenhum compromisso para este dia";
    } else {
      eventos.forEach(ev => {
        const div = document.createElement("div");
        div.classList.add("evento-dia");
        div.innerHTML = `
          <strong>${ev.eve_Titulo}</strong>
          <span>${ev.eve_Horario}</span>
        `;
        selectedList.appendChild(div);
      });
    }
  } catch (err) {
    console.error("Erro ao carregar compromissos do dia:", err);
    selectedList.textContent = "Erro ao carregar compromissos.";
  }
}

// =====================
// API: LISTAR TODOS OS EVENTOS (PRÓXIMOS)
// =====================
async function carregarEventos() {
  try {
    const response = await fetch("../api/Agenda/list.php");
    const eventos = await response.json();

    const container = document.querySelector(".appointments");
    container.innerHTML = "<h3>Próximos Compromissos</h3>";

    if (eventos.length > 0) {
      eventos.forEach(ev => {
        const div = document.createElement("div");
        div.classList.add("appointment");

        const cores = {
          "Reunião": "azul",
          "Pagamento": "vermelho",
          "Entrega": "laranja",
          "Outro": "verde"
        };
        div.classList.add(cores[ev.tipo] || "verde");

        div.innerHTML = `
          <strong>${ev.titulo}</strong>
          <span>${ev.data} às ${ev.horario}</span>
          <p>${ev.descricao || ""}</p>
          <button class="btn-acao btn-concluir" onclick="concluirEvento(${ev.id})">
            <i class="bi bi-check-lg"></i> Concluir
          </button>
          <button class="btn-acao btn-apagar" onclick="deletarEvento(${ev.id})">
            <i class="bi bi-trash"></i> Excluir
          </button>
        `;
        container.appendChild(div);
      });
    } else {
      container.innerHTML += "<p>Não existe nenhum compromisso</p>";
    }
  } catch (err) {
    console.error("Erro ao carregar eventos:", err);
  }
}

// =====================
// API: CRIAR EVENTO
// =====================
async function criarEvento(form) {
  const fd = new FormData(form);

  try {
    const response = await fetch("../api/Agenda/create.php", {
      method: "POST",
      body: fd
    });

    const result = await response.json();
    if (result.success) {
      carregarEventos();
    } else {
      alert("Erro ao criar compromisso: " + result.message);
    }
  } catch (err) {
    alert("Erro na requisição de criação.");
    console.error(err);
  }
}

// =====================
// API: CONCLUIR EVENTO
// =====================
async function concluirEvento(id) {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch("../api/Agenda/concluir.php", {
      method: "POST",
      body: formData
    });

    const result = await response.json();
    if (result.success) {
      const btn = document.querySelector(`.btn-concluir[onclick="concluirEvento(${id})"]`);
      if (btn) {
        const appointmentDiv = btn.closest(".appointment");
        if (appointmentDiv) {
          appointmentDiv.remove();
        }
      }
    } else {
      alert("Erro ao concluir: " + result.message);
    }
  } catch (err) {
    alert("Erro na requisição de conclusão.");
    console.error(err);
  }
}

// =====================
// API: DELETAR EVENTO
// =====================
async function deletarEvento(id) {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch("../api/Agenda/delete.php", {
      method: "POST",
      body: formData
    });

    const result = await response.json();
    if (result.success) {
      carregarEventos();
    } else {
      alert("Erro ao apagar: " + result.message);
    }
  } catch (err) {
    alert("Erro na requisição de exclusão.");
    console.error(err);
  }
}

// =====================
// MODAL NOVO COMPROMISSO
// =====================
document.querySelector(".btn-novo").addEventListener("click", () => {
  document.getElementById("modalBg").style.display = "flex";
});

function fecharModal() {
  document.getElementById("modalBg").style.display = "none";
}

document.querySelector(".salvar").addEventListener("click", (e) => {
  e.preventDefault();

  const form = document.getElementById("formCompromisso");

  const titulo = form.titulo.value;
  const data = form.data.value;
  const hora = form.horario.value;
  const tipo = form.tipo.value;

  if (!titulo || !data || !hora || !tipo) {
    alert("Por favor, preencha todos os campos obrigatórios.");
    return;
  }

  criarEvento(form);
  fecharModal();
  form.reset();
});

// Inicialização
carregarEventos();
