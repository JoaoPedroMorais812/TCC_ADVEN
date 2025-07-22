function abrirHistorico() {
    document.querySelector('.principal').style.display = 'none';
    document.getElementById('historicoPage').style.display = 'block';
}

function fecharHistorico() {
    document.getElementById('historicoPage').style.display = 'none';
    document.querySelector('.principal').style.display = 'block';
}
