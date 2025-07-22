<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suportes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Css/style-suporte.css">
</head>

<body>
  <main>
  <section class="py-5 text-center container bg-section">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Algum Problema?</h1>
          <p class="lead text-body-secondary">
            Com essa Página esperamos resolver seus problemas ou dúvidas. Espero que tenha ajudado.
          </p>
          <p>
            <a href="#" class="btn btn-primary my-2">Entrar em Contato</a>
            <a href="#" class="btn btn-secondary my-2">Dúvidas</a>
          </p>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-body-tertiary">
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <!-- Cartão 1 -->
          <div class="col">
  <div class="card shadow-sm">
    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg"
         role="img" preserveAspectRatio="xMidYMid slice" aria-label="Placeholder: Thumbnail">
      <rect width="100%" height="100%" fill="#e9ecef"/>
    </svg>
    <div class="card-body">
      <p class="card-text">Problemas em desempenho</p>
      <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group">
          <button class="btn btn-sm btn-outline-primary" onclick="mostrarSelect(this)">Sim</button>
          <button class="btn btn-sm btn-outline-danger">Não</button>
        </div>
      </div>

      <!-- Select oculto -->
      <div class="mt-3 select-container" style="display: none;">
        <select class="form-select" aria-label="Default select example">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
    </div>
  </div>
</div>


          <!-- Cartão 2 -->
          <div class="col">
            <div class="card shadow-sm">
              <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg"
                role="img" preserveAspectRatio="xMidYMid slice" aria-label="Placeholder: Thumbnail">
                <rect width="100%" height="100%" fill="#e9ecef" />
              </svg>
              <div class="card-body">
                <p class="card-text">Problemas em Conexão</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary">Sim</button>
                    <button class="btn btn-sm btn-outline-danger">Não</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Cartão 3 -->
          <div class="col">
            <div class="card shadow-sm">
              <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg"
                role="img" preserveAspectRatio="xMidYMid slice" aria-label="Placeholder: Thumbnail">
                <rect width="100%" height="100%" fill="#e9ecef" />
              </svg>
              <div class="card-body">
                <p class="card-text">Outros problemas</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button class="btn btn-sm btn-outline-primary">Sim</button>
                    <button class="btn btn-sm btn-outline-danger">Não</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous">
    function mostrarSelect(botao) {
      const cardBody = botao.closest('.card-body');
      const selectContainer = cardBody.querySelector('.select-container');
      selectContainer.style.display = 'block';
    }
  </script>
</body>

</html>