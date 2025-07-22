function abrirHistorico() {
    const novaJanela = window.open("", "_blank", "width=500,height=400");

    const conteudo = `
        <html>
        <head>
            <title>Histórico</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 20px;
                }
                ul {
                    padding-left: 20px;
                }
                .ver-mais {
                    margin-top: 20px;
                    text-align: center;
                    font-weight: bold;
                    text-decoration: underline;
                    cursor: pointer;
                }
            </style>
        </head>
        <body>
            <h2>Histórico</h2>
            <ul>
                <li>Investimento: R$ 500</li>
                <li>Despesa Fixa: R$ 250</li>
                <li>Outro item: R$ 300</li>
            </ul>
            <div class="ver-mais">Ver mais</div>
        </body>
        </html>
    `;

    novaJanela.document.write(conteudo);
    novaJanela.document.close();
}
