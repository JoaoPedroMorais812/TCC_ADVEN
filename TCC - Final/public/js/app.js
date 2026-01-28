// Funções JavaScript simples para os botões (apenas para demonstração)
function confirmarDebito() {
    const valor = document.getElementById('inputDebitos').value;
    alert('Débito de R$ ' + (parseFloat(valor) || 0).toFixed(2) + ' confirmado!');
}

function confirmarLucro() {
    const valor = document.getElementById('inputLucros').value;
    alert('Lucro de R$ ' + (parseFloat(valor) || 0).toFixed(2) + ' confirmado!');
}

function salvarNotaEvento() {
    const nota = document.getElementById('eventNotes').value;
    if (nota.trim() === '') {
        alert('A nota do evento está vazia. Por favor, digite algo.');
        return;
    }
    alert('Nota do evento salva: "' + nota + '"');
    // Numa aplicação real, enviaria esta nota para um backend ou guardaria localmente.
    document.getElementById('eventNotes').value = ''; // Limpa o campo
}

function verHistoricoCompleto() {
    // Redireciona o utilizador para a página 'receitas.html'
    window.location.href = 'receitas.html';
}

function verHistoricoDebitos() {
    alert('Clicou em "Ver Histórico de Débitos"! Numa aplicação real, isto mostraria o histórico de débitos.');
    // Aqui implementaria a navegação para uma página de histórico de débitos ou abriria um modal.
}
