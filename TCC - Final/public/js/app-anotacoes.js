let notes = [];
let editIndex = null;

// Carregar notas do banco
function loadNotes() {
  fetch("../api/Anotacoes/list.php")
    .then(res => res.json())
    .then(data => {
      notes = data.map(n => ({
        id: n.id,
        title: n.titulo,
        content: n.conteudo,
        color: n.cor,
        date: n.data_edicao ? n.data_edicao : n.data_criacao,
        favorite: n.favorita == 1,
        edited: !!n.data_edicao
      }));
      renderNotes();
    })
    .catch(err => console.error("Erro ao carregar notas:", err));
}

function renderNotes(filter = "") {
  const favoriteContainer = document.getElementById("favoriteNotes");
  const allContainer = document.getElementById("allNotes");

  favoriteContainer.innerHTML = "";
  allContainer.innerHTML = "";

  const q = (filter || "").toLowerCase();

  notes.forEach((note, index) => {
    const t = note.title.toLowerCase();
    const c = note.content.toLowerCase();

    if (q && !t.includes(q) && !c.includes(q)) return;

    const div = document.createElement("div");
    div.className = `nota ${note.color}`;

    div.innerHTML = `
      <h3>${escapeHtml(note.title)}</h3>
      ${note.content
        .split("\n")
        .map((line) => `<p>${escapeHtml(line)}</p>`)
        .join("")}
      <div class="nota-footer">
        <span><i class="bi bi-clock"></i> ${note.edited ? "Editado" : "Criado"}: ${note.date}</span>
        <div class="actions">
          <i class="bi ${note.favorite ? "bi-star-fill" : "bi-star"}" onclick="toggleFavorite(${index})"></i>
          <i class="bi bi-pencil" onclick="openModal(${index})"></i>
          <i class="bi bi-trash text-red" onclick="deleteNote(${index})"></i>
        </div>
      </div>
    `;

    (note.favorite ? favoriteContainer : allContainer).appendChild(div);
  });

  const anyVisible =
    favoriteContainer.children.length + allContainer.children.length > 0;

  const noResultsMessage = document.getElementById("noResults");
  const favoritasTitulo = document.getElementById("favoritasTitulo");
  const todasTitulo = document.getElementById("todasTitulo");

  if (noResultsMessage && favoritasTitulo && todasTitulo) {
    noResultsMessage.style.display = anyVisible ? "none" : "block";
    favoritasTitulo.style.display = anyVisible ? "block" : "none";
    todasTitulo.style.display = anyVisible ? "block" : "none";
  }
}

function escapeHtml(text) {
  return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}

function toggleFavorite(index) {
  if (typeof index !== "number" || index < 0 || index >= notes.length) return;

  const note = notes[index];
  note.favorite = !note.favorite;

  // Atualizar no banco
  fetch("../api/Anotacoes/update.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      id: note.id,
      title: note.title,
      content: note.content,
      color: note.color,
      favorita: note.favorite ? 1 : 0
    })
  })
    .then(res => res.json())
    .then(data => {
      if (!data.success) alert("Erro ao atualizar favorito: " + data.message);
      loadNotes();
    })
    .catch(err => alert("Erro de conexão: " + err));
}

function deleteNote(index) {
  if (!Number.isInteger(index) || index < 0 || index >= notes.length) return;

  if (confirm("Tem certeza que deseja excluir esta nota?")) {
    const id = notes[index].id;

    fetch("../api/Anotacoes/delete.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          loadNotes(); // recarrega lista do banco
        } else {
          alert("Erro ao excluir: " + data.message);
        }
      })
      .catch(err => alert("Erro de conexão: " + err));
  }
}

// MODAL NOVA ANOTAÇÃO 
function openModal(index = null) {
  const modal = document.getElementById("noteModal");
  const titleInput = document.getElementById("noteTitle");
  const contentInput = document.getElementById("noteContent");
  const favoriteInput = document.getElementById("noteFavorite");
  const modalTitle = document.getElementById("modalTitle");
  const btnSave = document.getElementById("btnSave");

  editIndex = typeof index === "number" ? index : null;
  modal.classList.remove("hidden");

  if (editIndex !== null && notes[editIndex]) {
    const n = notes[editIndex];
    titleInput.value = n.title;
    contentInput.value = n.content;
    favoriteInput.checked = !!n.favorite;

    document
      .querySelectorAll('input[name="noteColor"]')
      .forEach((r) => (r.checked = r.value === n.color));

    modalTitle.textContent = "Editar Anotação";
    btnSave.textContent = "Salvar";
  } else {
    titleInput.value = "";
    contentInput.value = "";
    favoriteInput.checked = false;

    document.querySelector(
      'input[name="noteColor"][value="amarelo"]'
    ).checked = true;

    modalTitle.textContent = "Nova Anotação";
    btnSave.textContent = "Criar";
  }
}

function closeModal() {
  document.getElementById("noteModal").classList.add("hidden");
  editIndex = null;
}

function saveNote() {
  const title = document.getElementById("noteTitle").value.trim();
  const content = document.getElementById("noteContent").value.trim();
  const color = document.querySelector('input[name="noteColor"]:checked')?.value || "amarelo";
  const favorite = document.getElementById("noteFavorite").checked;

  if (!title || !content) {
    alert("Título e conteúdo são obrigatórios!");
    return;
  }

  // Se for edição → chama update.php
  if (editIndex !== null && notes[editIndex]) {
    const id = notes[editIndex].id;

    fetch("../api/Anotacoes/update.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, title, content, color, favorita: favorite ? 1 : 0 })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          closeModal();
          loadNotes();
        } else {
          alert("Erro ao atualizar: " + data.message);
        }
      })
      .catch(err => alert("Erro de conexão: " + err));

    return;
  }

  // Criar nova anotação no banco
  fetch("../api/Anotacoes/create.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ title, content, color, favorite })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        closeModal();
        loadNotes(); // recarrega lista do banco sem precisar dar F5
      } else {
        alert("Erro ao salvar: " + data.message);
      }
    })
    .catch(err => alert("Erro de conexão: " + err));
}

document.addEventListener("DOMContentLoaded", () => {
  const btnNova = document.querySelector(".btn-nova");
  if (btnNova) btnNova.addEventListener("click", () => openModal());

  document.getElementById("btnCancel")?.addEventListener("click", (e) => {
    e.preventDefault();
    closeModal();
  });

  document.getElementById("btnSave")?.addEventListener("click", (e) => {
    e.preventDefault();
    saveNote();
  });

  // ✅ Carrega notas do banco ao abrir a página
  loadNotes();

  const menuBtn = document.querySelector(".menu-btn");
  const sidebar = document.querySelector(".sidebar");
  menuBtn?.addEventListener("click", () => sidebar.classList.toggle("active"));

  const searchInput = document.getElementById("search");
  if (searchInput) {
    searchInput.addEventListener("input", () =>
      renderNotes(searchInput.value)
    );
  }
});

function searchNotes() {
  const q = document.getElementById("search").value || "";
  renderNotes(q);
}
