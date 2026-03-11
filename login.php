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
                        <div class="position-absolute opacity-25" style="top: -10px; right: -10px; transform: rotate(15deg);">
                             <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </div>
                        
                        <h2 class="fw-bold mb-2 position-relative z-1">Bem-vindo(a)</h2>
                        <p class="mb-0 fs-5 position-relative z-1 opacity-75">Acesse sua plataforma</p>
                    </div>

                    <div class="p-4 p-md-5">
                        <form>
                            
                            <div class="mb-4">
                                <label for="codigoAcesso" class="form-label fw-bold small text-uppercase text-muted px-2">Código de Acesso</label>
                                <div class="input-group input-group-lg rounded-pill px-2 py-1" style="background-color: #F4F6F8;">
                                    <input type="password" class="form-control bg-transparent border-0 shadow-none fs-6" id="codigoAcesso" placeholder="Digite seu código" style="color: #2D3748;">
                                    <button class="btn bg-transparent border-0 text-muted shadow-none rounded-circle me-1" type="button" id="btnOlho">
                                        <svg id="iconeOlho" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold small text-uppercase text-muted px-2">Entrar como</label>
                                <div class="d-flex rounded-pill p-1" style="background-color: #F4F6F8;">
                                    
                                    <input type="radio" class="btn-check" name="tipoAcesso" id="acessoSala" autocomplete="off" checked>
                                    <label class="btn btn-outline-secondary border-0 w-100 rounded-pill py-2 fw-semibold text-dark shadow-none" for="acessoSala">Sala</label>

                                    <input type="radio" class="btn-check" name="tipoAcesso" id="acessoProfessor" autocomplete="off">
                                    <label class="btn btn-outline-secondary border-0 w-100 rounded-pill py-2 fw-semibold text-dark shadow-none" for="acessoProfessor">Professor</label>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: #3182CE; color: #FFFFFF; font-size: 1.1rem;">
                                Entrar
                            </button>
                            
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('btnOlho').addEventListener('click', function() {
            var inputCodigo = document.getElementById('codigoAcesso');
            var icone = document.getElementById('iconeOlho');
            
            if (inputCodigo.type === 'password') {
                inputCodigo.type = 'text';
                icone.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755l-.809-.805zm-4.305-4.305a2.5 2.5 0 0 1 1.442 1.442l-1.442-1.442zm-1.091-1.091a3.5 3.5 0 0 0-3.5 3.5l1.091 1.091a2.5 2.5 0 0 1 2.409-2.409l-2.409-2.409z"/><path d="M11.35 8.966 8 5.616 4.65 8.966l-.708-.708L7.292 4.908l1.416 1.416 3.35-3.35.708.708-4 4z"/><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>';
            } else {
                inputCodigo.type = 'password';
                icone.innerHTML = '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>';
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>