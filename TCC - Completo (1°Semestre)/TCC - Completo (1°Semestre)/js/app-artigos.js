// Filtro de busca simples (opcional para JS)
document.querySelector('input[type="text"]').addEventListener('input', function (e) {
  const val = e.target.value.toLowerCase();
  document.querySelectorAll('.card').forEach(card => {
    card.style.display = card.innerText.toLowerCase().includes(val) ? 'block' : 'none';
  });
});
