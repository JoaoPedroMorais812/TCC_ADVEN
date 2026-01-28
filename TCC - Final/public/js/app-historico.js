// app-historico.js — versão corrigida, otimizada e finalizada
(() => {

    const ENDPOINT = "../api/Historico/process-historico.php";
    const DELETE_ENDPOINT = "../api/Historico/delete-historico.php";
    const UPDATE_ENDPOINT = "../api/Historico/edit-historico.php";

    let receitasOriginais = [];

    let filtros = {
        periodo: "Todas as despesas",
        fontes: "Todas as fontes",
        dateFrom: "",
        dateTo: "",
        minValor: null,
        maxValor: null,
        search: ""
    };

    // Helpers DOM
    const $ = sel => document.querySelector(sel);
    const $$ = sel => Array.from(document.querySelectorAll(sel));

    // =========================
    // INICIALIZAÇÃO
    // =========================
    document.addEventListener("DOMContentLoaded", () => {
        injectAdvancedFilters();
        injectEditModal();
        bindUI();
        carregarReceitas();
    });

    // =========================
    // BUSCAR DADOS DO SERVIDOR
    // =========================
    async function carregarReceitas() {
        try {
            const res = await fetch(ENDPOINT);
            const json = await res.json();

            if (json.status !== "success") {
                console.error("Erro ao carregar dados:", json.mensagem);
                return;
            }

            receitasOriginais = json.dados.map(normalizeItem);

            populateFilterOptions(receitasOriginais);
            aplicarFiltrosEAtualizar();

        } catch (err) {
            console.error("Erro ao carregar dados:", err);
        }
    }

    function normalizeItem(d) {
        return {
            id: d.id,
            data: d.data || "",
            conta: d.conta || d.reg_Nome || "",
            fonte: d.natureza || "-", 
            valor: d.valor ? parseFloat(d.valor) : 0,
            recorrencia: d.recorrencia || null,
            descricao: d.descricao || "",
            idNatureza: d.idNatureza || null,
            idRecorrencia: d.idRecorrencia || null
        };
    }

    // =========================
    // FILTROS (UI)
    // =========================
    function injectAdvancedFilters() {
        const filterBar = $(".filter-bar");
        if (!filterBar) return;

        const extra = document.createElement("div");
        extra.className = "advanced-filters";
        extra.style.display = "flex";
        extra.style.gap = "8px";

        // itens
        const from = createInput("date", "filter-date-from");
        const to = createInput("date", "filter-date-to");
        const min = createInput("number", "filter-min-valor", "Min R$");
        const max = createInput("number", "filter-max-valor", "Max R$");

        min.step = "0.01";
        max.step = "0.01";

        // botão aplicar
        const aplicar = document.createElement("button");
        aplicar.className = "btn btn-sm btn-outline-light";
        aplicar.textContent = "Aplicar filtros";
        aplicar.onclick = () => {
            filtros.dateFrom = from.value;
            filtros.dateTo = to.value;
            filtros.minValor = min.value ? parseFloat(min.value) : null;
            filtros.maxValor = max.value ? parseFloat(max.value) : null;
            aplicarFiltrosEAtualizar();
        };

        // botão limpar
        const limpar = document.createElement("button");
        limpar.className = "btn btn-sm btn-outline-secondary";
        limpar.textContent = "Limpar filtros";
        limpar.onclick = resetarFiltros;

        extra.append(from, to, min, max, aplicar, limpar);

        filterBar.appendChild(extra);

        // adicionar classes iguais ao search
        setTimeout(() => {
            from.classList.add("input-icon", "icon-calendar");
            to.classList.add("input-icon", "icon-calendar");
            min.classList.add("input-icon", "icon-money");
            max.classList.add("input-icon", "icon-money");
        }, 100);
    }

    function createInput(type, id, placeholder = "") {
        const inp = document.createElement("input");
        inp.type = type;
        inp.id = id;
        if (placeholder) inp.placeholder = placeholder;
        return inp;
    }

    function resetarFiltros() {
        filtros = {
            periodo: "Todas as despesas",
            fontes: "Todas as fontes",
            dateFrom: "",
            dateTo: "",
            minValor: null,
            maxValor: null,
            search: ""
        };

        $("#filter-date-from").value = "";
        $("#filter-date-to").value = "";
        $("#filter-min-valor").value = "";
        $("#filter-max-valor").value = "";
        $("#search-input").value = "";
        $("#filter-periodo").value = "Todas as despesas";
        $("#filter-fontes").value = "Todas as fontes";

        aplicarFiltrosEAtualizar();
    }

    // preenche filtro de fontes
    function populateFilterOptions(lista) {
        const selectFontes = $("#filter-fontes");

        if (!selectFontes) return;

        while (selectFontes.options.length > 1)
            selectFontes.remove(1);

        const fontes = Array.from(new Set(lista.map(i => i.fonte).filter(Boolean)));

        fontes.forEach(f => {
            const opt = document.createElement("option");
            opt.value = f;
            opt.textContent = f;
            selectFontes.appendChild(opt);
        });
    }

    // =========================
    // FILTAGEM
    // =========================
    function aplicarFiltrosEAtualizar() {
        let lista = [...receitasOriginais];

        const termo = ($("#search-input")?.value || "").toLowerCase();

        if (termo) {
            lista = lista.filter(i =>
                i.conta.toLowerCase().includes(termo) ||
                (i.fonte || "").toLowerCase().includes(termo) ||
                (i.recorrencia || "").toLowerCase().includes(termo) ||
                String(i.valor).includes(termo)
            );
        }

        const periodo = $("#filter-periodo")?.value;
        if (periodo && periodo !== "Todas as despesas") {
            const hoje = new Date();
            const diasAtras = x => new Date(hoje.getTime() - x * 86400000);

            const map = {
                "Últimos 7 dias": 7,
                "Últimos 30 dias": 30,
                "Últimos 6 meses": 180,
                "Último ano": 365
            };

            lista = lista.filter(i => safeDate(i.data) >= diasAtras(map[periodo]));
        }

        const fonteSel = $("#filter-fontes")?.value;
        if (fonteSel !== "Todas as fontes")
            lista = lista.filter(i => i.fonte?.toLowerCase() === fonteSel.toLowerCase());

        if (filtros.dateFrom)
            lista = lista.filter(i => safeDate(i.data) >= safeDate(filtros.dateFrom));

        if (filtros.dateTo)
            lista = lista.filter(i => safeDate(i.data) <= safeDate(filtros.dateTo));

        if (filtros.minValor !== null)
            lista = lista.filter(i => i.valor >= filtros.minValor);

        if (filtros.maxValor !== null)
            lista = lista.filter(i => i.valor <= filtros.maxValor);

        atualizarTabela(lista);
    }

    function safeDate(v) {
        const d = new Date(v);
        return isNaN(d) ? new Date("0001-01-01") : d;
    }

    // =========================
    // ATUALIZAR TABELA
    // =========================
    function atualizarTabela(lista) {
        const tbody = $("#table-content");
        tbody.innerHTML = "";

        let totalValor = 0;

        lista.forEach(item => {
            totalValor += item.valor;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${item.data}</td>
                <td>${escapeHtml(item.conta)}</td>
                <td>${escapeHtml(item.fonte || "-")}</td>
                <td>R$ ${item.valor.toFixed(2).replace(".", ",")}</td>
                <td>${escapeHtml(item.recorrencia || "-")}</td>
                <td><button class="btn btn-warning btn-sm btn-edit" data-id="${item.id}">Editar</button></td>
                <td><button class="btn btn-danger btn-sm btn-delete" data-id="${item.id}">Excluir</button></td>
            `;
            tbody.appendChild(tr);
        });

        $("#total-lancamentos").textContent =
            `${lista.length} lançamentos — Total R$ ${totalValor.toFixed(2).replace('.', ',')}`;

        // eventos
        $$(".btn-edit").forEach(btn => btn.onclick = onEditClick);
        $$(".btn-delete").forEach(btn => btn.onclick = onDeleteClick);
    }

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, t => ({
            "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;"
        })[t]);
    }

    // =========================
    // RESPONSIVIDADE
    // =========================
    function bindUI() {
        const search = $("#search-input");
        if (search) search.oninput = aplicarFiltrosEAtualizar;

        $("#filter-periodo").onchange = aplicarFiltrosEAtualizar;
        $("#filter-fontes").onchange = aplicarFiltrosEAtualizar;
    }

    // =========================
    // EXCLUIR
    // =========================
    async function onDeleteClick(e) {
        const id = e.currentTarget.dataset.id;

        if (!confirm("Deseja realmente excluir?"))
            return;

        const fd = new FormData();
        fd.append("id", id);

        const res = await fetch(DELETE_ENDPOINT, { method: "POST", body: fd });
        const json = await res.json();

        if (json.status === "success") {
            receitasOriginais = receitasOriginais.filter(x => x.id != id);
            aplicarFiltrosEAtualizar();
            alert("Registro excluído!");
        } else {
            alert("Erro: " + json.mensagem);
        }
    }

    // =========================
    // EDITAR — MODAL
    // =========================
    function injectEditModal() {

        if ($("#edit-modal")) return;

        document.body.insertAdjacentHTML("beforeend", `
            <div id="edit-modal" style="display:none; position:fixed; inset:0; background:#0009; 
                    align-items:center; justify-content:center; z-index:3000;">
                <div style="background:var(--bg-panel); padding:20px; border-radius:10px; width:100%; max-width:500px;">
                    <h4>Editar Registro</h4>

                    <form id="edit-form">
                        <input type="hidden" name="id" id="edit-id">

                        <label>Nome</label>
                        <input class="form-control" name="nome" id="edit-nome" required>

                        <label>Valor (R$)</label>
                        <input type="number" step="0.01" class="form-control" name="valor" id="edit-valor" required>

                        <label>Data</label>
                        <input type="date" class="form-control" name="data" id="edit-data" required>

                        <label>Categoria</label>
                        <select class="form-control" name="natureza" id="edit-natureza"></select>

                        <label>Recorrência</label>
                        <select class="form-control" name="recorrencia" id="edit-recorrencia"></select>

                        <label>Descrição</label>
                        <textarea class="form-control" name="descricao" id="edit-descricao"></textarea>

                        <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:15px;">
                            <button type="button" class="btn btn-secondary" id="edit-cancel">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>
                </div>
            </div>
        `);

        $("#edit-cancel").onclick = closeEditModal;
        $("#edit-form").onsubmit = onSaveEdit;
    }

    function openEditModalById(id) {

        const item = receitasOriginais.find(r => r.id == id);

        if (!item) return;

        $("#edit-id").value = item.id;
        $("#edit-nome").value = item.conta;
        $("#edit-valor").value = item.valor;
        $("#edit-data").value = item.data;
        $("#edit-descricao").value = item.descricao;

        fillEditSelects(item);

        $("#edit-modal").style.display = "flex";
    }

    function closeEditModal() {
        $("#edit-modal").style.display = "none";
    }

    function fillEditSelects(item) {

        const selNat = $("#edit-natureza");
        const selRec = $("#edit-recorrencia");

        selNat.innerHTML = "<option value=''>--</option>";
        selRec.innerHTML = "<option value=''>--</option>";

        const naturezas = {};
        const recorrencias = {};

        receitasOriginais.forEach(r => {
            if (r.idNatureza && r.fonte)
                naturezas[r.idNatureza] = r.fonte;

            if (r.idRecorrencia && r.recorrencia)
                recorrencias[r.idRecorrencia] = r.recorrencia;
        });

        Object.entries(naturezas).forEach(([id, nome]) => {
            selNat.innerHTML += `<option value="${id}">${nome}</option>`;
        });

        Object.entries(recorrencias).forEach(([id, nome]) => {
            selRec.innerHTML += `<option value="${id}">${nome}</option>`;
        });

        selNat.value = item.idNatureza || "";
        selRec.value = item.idRecorrencia || "";
    }

    function onEditClick(e) {
        openEditModalById(e.currentTarget.dataset.id);
    }

    async function onSaveEdit(e) {
        e.preventDefault();

        const fd = new FormData(e.target);

        const res = await fetch(UPDATE_ENDPOINT, { method: "POST", body: fd });
        const json = await res.json();

        if (json.status === "success") {

            const id = fd.get("id");
            const item = receitasOriginais.find(r => r.id == id);

            if (item) {
                item.conta = fd.get("nome");
                item.valor = parseFloat(fd.get("valor"));
                item.data = fd.get("data");
                item.descricao = fd.get("descricao");
                item.idNatureza = fd.get("natureza");
                item.idRecorrencia = fd.get("recorrencia");

                // texto exibido
                const optNat = $("#edit-natureza").selectedOptions[0];
                const optRec = $("#edit-recorrencia").selectedOptions[0];

                item.fonte = optNat ? optNat.textContent : item.fonte;
                item.recorrencia = optRec ? optRec.textContent : item.recorrencia;
            }

            closeEditModal();
            aplicarFiltrosEAtualizar();
            alert("Registro atualizado!");

        } else {
            alert("Erro: " + json.mensagem);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
    const btnExportar = document.querySelector("#btn-exportar-receitas");

    if (btnExportar) {
        btnExportar.addEventListener("click", () => {
            window.location.href = "../api/Historico/exportar-receitas.php";
        });
    }
});


})();

