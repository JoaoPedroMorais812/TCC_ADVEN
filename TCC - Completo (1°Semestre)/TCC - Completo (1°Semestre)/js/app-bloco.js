// Lista de anotações
let notes = [
  {
    title: "Senhas Importantes",
    content: "Banco do Brasil: usuario123\nItaú: empresa456\nReceita Federal: cnpj789",
    color: "amarelo",
    date: "14/01/2025, 21:00",
    favorite: true
  },
  {
    title: "Ideias para Melhorias",
    content: "Sistema de gestão:\n- Automatizar relatórios\n- Integrar com banco\n- Melhorar interface",
    color: "verde",
    date: "13/01/2025, 21:00",
    favorite: true
  },
  {
    title: "Reunião Cliente ABC",
    content: "Pontos importantes:\n- Apresentar nova proposta\n- Discutir prazos\n- Negociar valores",
    color: "azul",
    date: "11/01/2025, 21:00",
    favorite: false
  },
  {
    title: "Fornecedores",
    content: "Lista de fornecedores aprovados:\n1. Empresa X – (11) 1234-5678\n2. Empresa Y – (11) 8765-4321\n3. Empresa Z – (11) 5555-5555",
    color: "roxo",
    date: "12/01/2025, 21:00",
    favorite: false
  }
];

let editIndex = null; // Índice da nota sendo editada (null se for nova)

// Renderiza as notas na tela, com filtro opcional
function renderNotes(filter = "") {
  const favoriteContainer = document.getElementById("favoriteNotes");
  const allContainer = document.getElementById("allNotes");

  favoriteContainer.innerHTML = "";
  allContainer.innerHTML = "";

  notes.forEach((note, index) => {
    const lowerTitle = note.title.toLowerCase();
    const lowerContent = note.content.toLowerCase();

    // Ignora notas que não correspondem ao filtro de busca
    if (!lowerTitle.includes(filter) && !lowerContent.includes(filter)) return;

    // Cria o elemento da nota
    const div = document.createElement("div");
    div.className = `nota ${note.color}`;
    div.innerHTML = `
      <h3>${note.title}</h3>
      ${note.content.split('\n').map(line => `<p>${line}</p>`).join('')}
      <div class="nota-footer">
        <span><i class="bi bi-clock"></i> ${note.favorite ? 'Editado' : 'Criado'}: ${note.date}</span>
        <div class="actions">
          <i class="bi ${note.favorite ? 'bi-star-fill' : 'bi-star'}" onclick="toggleFavorite(${index})"></i>
          <i class="bi bi-pencil" onclick="openModal(${index})"></i>
          <i class="bi bi-trash text-red" onclick="deleteNote(${index})"></i>
        </div>
      </div>
    `;

    // Adiciona no container correto
    if (note.favorite) {
      favoriteContainer.appendChild(div);
    } else {
      allContainer.appendChild(div);
    }
  });
}

// Alterna o status de favorito da nota
function toggleFavorite(index) {
  notes[index].favorite = !notes[index].favorite;
  renderNotes(document.getElementById("search")?.value.toLowerCase() || "");
}

// Exclui uma nota após confirmação
function deleteNote(index) {
  if (confirm("Tem certeza que deseja excluir esta nota?")) {
    notes.splice(index, 1); // Remove do array
    renderNotes(document.getElementById("search")?.value.toLowerCase() || "");
  }
}

// Abre o modal para criar ou editar nota
function openModal(index = null) {
  const modal = document.getElementById("noteModal");
  modal.classList.remove("hidden");
  editIndex = index;

  if (index !== null) {
    // Edição: preenche os dados da nota existente
    document.getElementById("noteTitle").value = notes[index].title;
    document.getElementById("noteContent").value = notes[index].content;
    document.querySelector(`input[name="noteColor"][value="${notes[index].color}"]`).checked = true;
    document.getElementById("noteFavorite").checked = notes[index].favorite;
  } else {
    // Nova nota: limpa os campos
    document.getElementById("noteTitle").value = "";
    document.getElementById("noteContent").value = "";
    document.querySelector('input[name="noteColor"][value="amarelo"]').checked = true;
    document.getElementById("noteFavorite").checked = false;
  }
}

// Fecha o modal de edição/criação
function closeModal() {
  document.getElementById("noteModal").classList.add("hidden");
}

// Salva uma nova nota ou edita existente
function saveNote() {
  const title = document.getElementById("noteTitle").value.trim();
  const content = document.getElementById("noteContent").value.trim();
  const color = document.querySelector('input[name="noteColor"]:checked')?.value || "amarelo";
  const favorite = document.getElementById("noteFavorite").checked;
  const now = new Date();
  const date = now.toLocaleString("pt-BR");

  if (!title || !content) {
    alert("Título e conteúdo são obrigatórios!");
    return;
  }

  const newNote = { title, content, color, date, favorite };

  if (editIndex !== null) {
    // Atualiza nota existente
    notes[editIndex] = newNote;
  } else {
    // Adiciona nova nota
    notes.push(newNote);
  }

  closeModal();
  renderNotes(document.getElementById("search")?.value.toLowerCase() || "");
}

// Filtra as notas com base na pesquisa
function searchNotes() {
  const query = document.getElementById("search").value.toLowerCase();
  const allNotes = document.querySelectorAll(".nota");
  let anyVisible = false;

  allNotes.forEach(nota => {
    const title = nota.querySelector("h3")?.innerText.toLowerCase() || "";
    const content = Array.from(nota.querySelectorAll("p"))
      .map(p => p.innerText.toLowerCase())
      .join(" ");

    const matches = title.includes(query) || content.includes(query);
    nota.style.display = matches ? "flex" : "none";

    if (matches) anyVisible = true;
  });

  const noResultsMessage = document.getElementById("noResults");
  const favoritasTitulo = document.getElementById("favoritasTitulo");
  const todasTitulo = document.getElementById("todasTitulo");

  if (anyVisible) {
    noResultsMessage.style.display = "none";
    favoritasTitulo.style.display = "block";
    todasTitulo.style.display = "block";
  } else {
    noResultsMessage.style.display = "block";
    favoritasTitulo.style.display = "none";
    todasTitulo.style.display = "none";
  }
}

// Executa ao carregar a página
document.addEventListener("DOMContentLoaded", function () {
  // Botão de nova anotação abre o modal
  document.querySelector(".btn-nova").addEventListener("click", () => {
    openModal();
  });

  // Renderiza notas iniciais
  renderNotes();
});

const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');

menuBtn.addEventListener('click', () => {
  sidebar.classList.toggle('active');
});

