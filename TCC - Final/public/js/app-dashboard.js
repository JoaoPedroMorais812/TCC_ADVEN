// =====================
// RESUMO FINANCEIRO (CARDS)
// =====================
async function carregarResumo(periodo = "Mensal") {
  try {
    const res = await fetch("../api/Dashboard/resumo.php?periodo=" + encodeURIComponent(periodo));
    const resumo = await res.json();

    document.querySelectorAll(".card").forEach(card => {
      const title = card.querySelector(".title").textContent.trim();
      const valueEl = card.querySelector("h2");
      const percentEl = card.querySelector(".percent"); // precisa existir no HTML

      if (title === "Créditos") {
        valueEl.textContent = `R$ ${resumo.creditos.toLocaleString("pt-BR")}`;
        if (percentEl) {
          percentEl.textContent = `${resumo.variacaoCreditos.toFixed(1)}%`;
          percentEl.className = "percent " + (resumo.variacaoCreditos >= 0 ? "positive" : "negative");
        }
      } else if (title === "Débitos") {
        valueEl.textContent = `R$ ${resumo.debitos.toLocaleString("pt-BR")}`;
        if (percentEl) {
          percentEl.textContent = `${resumo.variacaoDebitos.toFixed(1)}%`;
          percentEl.className = "percent " + (resumo.variacaoDebitos >= 0 ? "positive" : "negative");
        }
      } else if (title === "Saldo") {
        valueEl.textContent = `R$ ${resumo.saldo.toLocaleString("pt-BR")}`;
        if (percentEl) {
          percentEl.textContent = `${resumo.variacaoSaldo.toFixed(1)}%`;
          percentEl.className = "percent " + (resumo.variacaoSaldo >= 0 ? "positive" : "negative");
        }
      }
    });
  } catch (err) {
    console.error("Erro ao carregar resumo:", err);
  }
}

// =====================
// GRÁFICOS
// =====================
async function carregarGrafico(periodo = "Mensal") {
  try {
    const res = await fetch("../api/Dashboard/grafico.php?periodo=" + encodeURIComponent(periodo));
    const dados = await res.json();

    if (!Array.isArray(dados) || dados.length === 0) {
      console.warn("Nenhum dado retornado para o gráfico");
      return;
    }

    const meses = ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"];
    const diasSemana = {
      1: "Dom", 2: "Seg", 3: "Ter", 4: "Qua", 5: "Qui", 6: "Sex", 7: "Sáb"
    };

    let labels;

    if (periodo === "Diário") {
      labels = dados.map(d => `${d.label}h`);
    } else if (periodo === "Semanal") {
      labels = dados.map(d => diasSemana[d.label] || d.label);
    } else if (periodo === "Mensal") {
      labels = dados.map(d => meses[d.label - 1]);
    } else if (periodo === "Anual") {
      labels = dados.map(d => d.label);
    } else {
      labels = dados.map(d => d.label || "");
    }

    const creditos = dados.map(d => parseFloat(d.creditos) || 0);
    const debitos = dados.map(d => parseFloat(d.debitos) || 0);

    const chartData = {
      labels,
      datasets: [
        {
          label: "Créditos",
          data: creditos,
          backgroundColor: "rgba(34, 197, 94, 0.7)",
          borderColor: "rgba(34, 197, 94, 1)",
          fill: true
        },
        {
          label: "Débitos",
          data: debitos,
          backgroundColor: "rgba(239, 68, 68, 0.7)",
          borderColor: "rgba(239, 68, 68, 1)",
          fill: true
        }
      ]
    };

    const optionsBase = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: "bottom" } }
    };

    const canvasBarra = document.getElementById("graficoBarra");
    const canvasLinha = document.getElementById("graficoLinha");

    if (!canvasBarra || !canvasLinha) {
      console.error("Canvas não encontrado no HTML");
      return;
    }

    const ctxBarra = canvasBarra.getContext("2d");
    const ctxLinha = canvasLinha.getContext("2d");

    if (window.graficoBarra && typeof window.graficoBarra.destroy === "function") {
      window.graficoBarra.destroy();
    }
    if (window.graficoLinha && typeof window.graficoLinha.destroy === "function") {
      window.graficoLinha.destroy();
    }

    window.graficoBarra = new Chart(ctxBarra, {
      type: "bar",
      data: chartData,
      options: optionsBase
    });

    const dadosLinha = JSON.parse(JSON.stringify(chartData));
    dadosLinha.datasets.forEach(d => d.fill = false);

    window.graficoLinha = new Chart(ctxLinha, {
      type: "line",
      data: dadosLinha,
      options: optionsBase
    });

  } catch (err) {
    console.error("Erro ao carregar gráfico:", err);
  }
}

// =====================
// HISTÓRICO
// =====================
async function carregarHistorico() {
  try {
    const res = await fetch("../api/Dashboard/historico.php");
    const historico = await res.json();

    const tbody = document.getElementById("history-body");
    tbody.innerHTML = "";

    historico.slice(0, 8).forEach(item => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${item.descricao}</td>
        <td class="${item.tipo === 'Receita' ? 'positive' : 'negative'}">
          ${item.tipo === 'Receita' ? '+' : '-'}R$ ${parseFloat(item.valor).toLocaleString("pt-BR")}
        </td>
        <td>${new Date(item.data).toLocaleDateString("pt-BR")}</td>
        <td><span class="badge ${item.tipo.toLowerCase()}">${item.tipo}</span></td>
      `;
      tbody.appendChild(tr);
    });
  } catch (err) {
    console.error("Erro ao carregar histórico:", err);
  }
}

// =====================
// CONTROLES DE GRÁFICO
// =====================
document.getElementById("btnBarra").addEventListener("click", () => {
  document.getElementById("graficoBarra").style.display = "block";
  document.getElementById("graficoLinha").style.display = "none";
});

document.getElementById("btnLinha").addEventListener("click", () => {
  document.getElementById("graficoBarra").style.display = "none";
  document.getElementById("graficoLinha").style.display = "block";
});

// =====================
// SELECT DE PERÍODO
// =====================
const periodSelect = document.querySelector(".period-select");
periodSelect.addEventListener("change", () => {
  const periodo = periodSelect.value;
  carregarResumo(periodo);
  carregarGrafico(periodo);
});

// =====================
// INICIALIZAÇÃO
// =====================
window.addEventListener("DOMContentLoaded", () => {
  carregarResumo("Mensal");
  carregarGrafico("Mensal");
  carregarHistorico();
  document.getElementById("graficoBarra").style.display = "block";
});
