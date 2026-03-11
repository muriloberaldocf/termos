<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background-color: #F4F6F8; color: #2D3748;">

    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow border-0 p-4 p-md-5 rounded-4" style="background-color: #FFFFFF;">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; background-color: #F4F6F8; color: #3182CE;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #2D3748;">Entrar na plataforma</h3>
                        <p class="text-muted small">Informe seus dados para acessar</p>
                    </div>

                    <form>
                        <div class="mb-4">
                            <label for="codigoAcesso" class="form-label fw-bold small text-uppercase text-muted">Código de Acesso</label>
                            <div class="input-group input-group-lg rounded-3" style="background-color: #f8f9fa;"> <input type="password" class="form-control bg-transparent border-0 shadow-none" id="codigoAcesso" placeholder="Ex: PRO-1234" style="color: #2D3748;">
                                <button class="btn bg-transparent border-0 text-muted shadow-none" type="button" id="btnOlho">
                                    <svg id="iconeOlho" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tipo de Acesso</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="tipoAcesso" id="acessoSala" autocomplete="off" checked>
                                <label class="btn btn-outline-dark w-100 py-2 rounded-3 fw-semibold" for="acessoSala">Sala</label>

                                <input type="radio" class="btn-check" name="tipoAcesso" id="acessoProfessor" autocomplete="off">
                                <label class="btn btn-outline-dark w-100 py-2 rounded-3 fw-semibold" for="acessoProfessor">Professor</label>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: #3182CE; color: #FFFFFF; font-size: 1.1rem;">
                            Acessar Sistema
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('btnOlho').addEventListener('click', function() {
            var inputCodigo = document.getElementById('codigoAcesso');
            var icone = document.getElementById('iconeOlho');
            
            // Alterna entre password e text
            if (inputCodigo.type === 'password') {
                inputCodigo.type = 'text';
                // Troca para o ícone de olho cortado (opcional, para dar feedback visual)
                icone.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755l-.809-.805zm-4.305-4.305a2.5 2.5 0 0 1 1.442 1.442l-1.442-1.442zm-1.091-1.091a3.5 3.5 0 0 0-3.5 3.5l1.091 1.091a2.5 2.5 0 0 1 2.409-2.409l-2.409-2.409z"/><path d="M11.35 8.966 8 5.616 4.65 8.966l-.708-.708L7.292 4.908l1.416 1.416 3.35-3.35.708.708-4 4z"/><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>';
            } else {
                inputCodigo.type = 'password';
                // Volta para o ícone de olho normal
                icone.innerHTML = '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>';
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>