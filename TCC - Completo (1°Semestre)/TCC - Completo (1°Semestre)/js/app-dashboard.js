// ============================== TROCAR GRÁFICOS ==============================

// Seleciona o local onde o gráfico será exibido (placeholder)
const chartPlaceholder = document.querySelector(".chart-placeholder");

// Seleciona os botões de gráfico (barra e setor)
const barChartBtn = document.querySelector(".chart-btn:nth-child(1)");
const pieChartBtn = document.querySelector(".chart-btn:nth-child(2)");

// Ao clicar no botão de gráfico de colunas
barChartBtn.addEventListener("click", () => {
  chartPlaceholder.textContent = "Gráfico de Colunas";
});

// Ao clicar no botão de gráfico de setor
pieChartBtn.addEventListener("click", () => {
  chartPlaceholder.textContent = "Gráfico de Setor";
});


// ============================== TROCAR VALORES DOS CARDS POR PERÍODO ==============================

// Seleciona o <select> com os períodos (Diário, Semanal, etc.)
const periodSelect = document.querySelector(".period-select");

// Dados fictícios dos cards por período
const cardsData = {
  Diário: {
    receitas: "R$ 2.100,00",
    despesas: "R$ 1.550,00",
    lucro: "R$ 550,00",
    total: "R$ 3.650,00",
  },
  Semanal: {
    receitas: "R$ 14.700,00",
    despesas: "R$ 9.100,00",
    lucro: "R$ 5.600,00",
    total: "R$ 23.800,00",
  },
  Mensal: {
    receitas: "R$ 85.430,00",
    despesas: "R$ 54.280,00",
    lucro: "R$ 31.150,00",
    total: "R$ 139.710,00",
  },
  Anual: {
    receitas: "R$ 1.120.000,00",
    despesas: "R$ 720.000,00",
    lucro: "R$ 400.000,00",
    total: "R$ 1.840.000,00",
  },
};

// Quando o usuário troca o valor do período (select)
periodSelect.addEventListener("change", () => {
  const selected = periodSelect.value;         // Obtém o valor selecionado
  const data = cardsData[selected];            // Busca os dados correspondentes

  if (data) {
    // Percorre todos os cards
    document.querySelectorAll(".card").forEach((card) => {
      const title = card.querySelector(".title").textContent.trim();

      // Atualiza o valor do card com base no título
      if (title === "Receitas") {
        card.querySelector("h2").textContent = data.receitas;
      } else if (title === "Despesas") {
        card.querySelector("h2").textContent = data.despesas;
      } else if (title === "Lucro") {
        card.querySelector("h2").textContent = data.lucro;
      } else if (title === "Total") {
        card.querySelector("h2").textContent = data.total;
      }
    });
  }
});
