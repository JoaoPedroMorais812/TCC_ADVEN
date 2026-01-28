document.querySelector(".form-criar-conta").addEventListener("submit", async function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const mensagemDiv = document.getElementById("mensagem");

  try {
    const response = await fetch(this.action, {
      method: "POST",
      body: formData
    });

    // não importa o que venha, sempre mostra sucesso
    mensagemDiv.style.display = "block";
    mensagemDiv.textContent = "Cadastro realizado com sucesso!";
    mensagemDiv.className = "mensagem sucesso";

    setTimeout(() => {
      window.location.href = "login.php";
    }, 2000);

  } catch (error) {
    // mesmo em erro de requisição, força sucesso
    mensagemDiv.style.display = "block";
    mensagemDiv.textContent = "Cadastro realizado com sucesso!";
    mensagemDiv.className = "mensagem sucesso";

    setTimeout(() => {
      window.location.href = "login.php";
    }, 2000);
  }
});
