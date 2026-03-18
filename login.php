<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Integrado ao Tema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="background-color: #F4F6F8; color: #2D3748;">

    <div class="position-absolute opacity-25" style="top: 10%; left: 5%; transform: rotate(-20deg); color: #3182CE;">
        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v10.137a.5.5 0 0 0 .77.419C1.76 12.56 3.99 11.732 7.5 11.732c1.38 0 2.583.523 3.217 1.036a.5.5 0 0 0 .786-.441V2.5a.5.5 0 0 0-.11-.312C10.48 1.572 8.913 1.14 8 1.783z"/>
        </svg>
    </div>
    <div class="position-absolute opacity-25" style="bottom: 10%; right: 5%; transform: rotate(15deg); color: #DD6B20;">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" viewBox="0 0 16 16">
            <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
        </svg>
    </div>

    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background-color: #FFFFFF;">
                    
                    <div class="p-5 text-center position-relative" style="background-color: #3182CE; color: #FFFFFF;">
                        <h2 class="fw-bold mb-2 position-relative z-1">Bem-vindo(a)</h2>
                        <p class="mb-0 fs-5 position-relative z-1 opacity-75">Acesse sua plataforma</p>
                    </div>

                    <div class="p-4 p-md-5">
                        
                        <?php if (isset($_GET['erro'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($_GET['erro']); ?>
                            </div>
                        <?php endif; ?>

                        <form id="formLogin">
                            
                            <div class="mb-4">
                                <label for="codigoAcesso" class="form-label fw-bold small text-uppercase text-muted px-2">Código de Acesso</label>
                                <div class="input-group input-group-lg rounded-pill px-2 py-1" style="background-color: #F4F6F8;">
                                    <input type="password" name="codigoAcesso" class="form-control bg-transparent border-0 shadow-none fs-6" id="codigoAcesso" placeholder="Digite seu código" style="color: #2D3748;" required>
                                    <button class="btn bg-transparent border-0 text-muted shadow-none rounded-circle me-1" type="button" id="btnOlho">
                                        <svg id="iconeOlho" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- <div class="mb-5">
                                <label class="form-label fw-bold small text-uppercase text-muted px-2">Entrar como</label>
                                <div class="d-flex rounded-pill p-1" style="background-color: #F4F6F8;">
                                    <input type="radio" class="btn-check" name="tipoAcesso" value="sala" id="acessoSala" autocomplete="off" checked>
                                    <label class="btn btn-outline-secondary border-0 w-100 rounded-pill py-2 fw-semibold text-dark shadow-none" for="acessoSala">Sala</label>

                                    <input type="radio" class="btn-check" name="tipoAcesso" value="professor" id="acessoProfessor" autocomplete="off">
                                    <label class="btn btn-outline-secondary border-0 w-100 rounded-pill py-2 fw-semibold text-dark shadow-none" for="acessoProfessor">Professor</label>
                                </div>
                            </div> -->

                            <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: #3182CE; color: #FFFFFF; font-size: 1.1rem;">
                                Entrar
                            </button>
                            <div id="mensagem"></div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
document.getElementById('formLogin').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const codigoAcesso = document.getElementById('codigoAcesso').value;
    const msg = document.getElementById('mensagem');

    try {
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codigoAcesso: codigoAcesso })
        });

        // Debug: Veja o que o PHP está retornando no console do navegador (F12)
        const textoRetorno = await response.text();
        console.log("Resposta do Servidor:", textoRetorno);
        
        const result = JSON.parse(textoRetorno);

        if (result.success) {
            // Se o login funcionar, manda para o dashboard que criamos
            window.location.href = 'selecionar.php';
        } else {
            msg.innerText = result.message;
        }
    } catch (error) {
        console.error("Erro na requisição:", error);
        msg.innerText = "Erro ao conectar com o servidor.";
    }
});
    </script>
    <script>
    const btnOlho = document.getElementById('btnOlho');
    const inputCodigo = document.getElementById('codigoAcesso');
    const iconeOlho = document.getElementById('iconeOlho');

    // Caminhos do ícone (SVG do Bootstrap Icons)
    const iconeAberto = `<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>`;
    const iconeFechado = `<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>`;

    btnOlho.addEventListener('click', () => {
        // Verifica o tipo atual
        const isPassword = inputCodigo.getAttribute('type') === 'password';
        
        // Alterna o tipo
        inputCodigo.setAttribute('type', isPassword ? 'text' : 'password');
        
        // Alterna o ícone
        iconeOlho.innerHTML = isPassword ? iconeFechado : iconeAberto;
    });
</script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
