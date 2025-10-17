// ============================== FUNÇÕES DO CALENDÁRIO ==============================
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

  monthYear.textContent = `${date.toLocaleString("pt-BR", {
    month: "long",
  })} ${year}`;

  calendarDays.innerHTML = "";

  for (let i = 0; i < firstDay; i++) {
    calendarDays.innerHTML += "<div></div>";
  }

  for (let d = 1; d <= lastDate; d++) {
    const isToday =
      d === new Date().getDate() &&
      month === new Date().getMonth() &&
      year === new Date().getFullYear();

    calendarDays.innerHTML += `<div class="${isToday ? "today" : ""}" onclick="selectDate(${year}, ${month}, ${d})">${d}</div>`;
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

function selectDate(y, m, d) {
  const date = new Date(y, m, d);
  const formatted = date.toLocaleDateString("pt-BR", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric",
  });

  selectedDate.textContent =
    formatted.charAt(0).toUpperCase() + formatted.slice(1);
  selectedList.textContent = "Nenhum compromisso para este dia";
}

renderCalendar(currentDate);


// ============================== MODAL ==============================
// Abre o modal ao clicar em "+ Novo Compromisso"
document.querySelector(".btn-novo").addEventListener("click", () => {
  document.getElementById("modalBg").classList.add("show");
});

// Fecha o modal
function fecharModal() {
  document.getElementById("modalBg").classList.remove("show");
}

// Fecha o modal ao clicar em "Salvar"
document.querySelector(".salvar").addEventListener("click", () => {
  fecharModal();
});