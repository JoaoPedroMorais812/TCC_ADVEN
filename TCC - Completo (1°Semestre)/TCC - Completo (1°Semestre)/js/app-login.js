function togglePassword() {
  const senhaInput = document.getElementById('senha');
  const eyeIcon = document.querySelector('.eye img');
  
  if (senhaInput.type === 'password') {
    senhaInput.type = 'text';
    eyeIcon.src = 'eye-closed-icon.png'; // Ícone alternativo, se quiser
  } else {
    senhaInput.type = 'password';
    eyeIcon.src = 'eye-icon.png';
  }
}
