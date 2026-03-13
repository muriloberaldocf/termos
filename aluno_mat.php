<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matemática - Dicionário do Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Efeito de zoom ao passar o mouse */
        .card-clicavel {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
        }
        .card-clicavel:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        /* Limita o texto no card pequeno */
        .texto-limitado {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body class="min-vh-100" style="background-color: #F4F6F8; color: #2D3748;">

    <nav class="navbar shadow-sm py-3" style="background-color: #FFFFFF;">
        <div class="container d-flex justify-content-between align-items-center">
            
            <div class="d-flex align-items-center gap-3">
                <a href="selecionar.php" class="btn btn-light rounded-circle p-2 text-muted shadow-none border-0" style="background-color: #F4F6F8;" title="Voltar para a seleção">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                </a>
                <h4 class="mb-0 fw-bold" style="color: #DD6B20;">Matemática <span class="badge rounded-pill align-middle ms-2 bg-info text-white" style="font-size: 0.75rem;">Modo Aluno</span></h4>
            </div>
            
            <div class="d-flex gap-2">
                <button class="btn fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaFormula" style="background-color: #DD6B20; color: #FFFFFF;">
                    <span class="d-none d-sm-inline">+ Nova Fórmula</span>
                    <span class="d-inline d-sm-none">+</span> 
                </button>

                <a href="api/logout.php" class="btn btn-light text-danger fw-bold rounded-pill px-3 shadow-sm border-0 d-flex align-items-center gap-2" title="Sair da conta">
                    <span class="d-none d-sm-inline">Sair</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                </a>
            </div>

        </div>
    </nav>

    <div class="container py-5">
        
        <div class="row mb-5 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="input-group input-group-lg rounded-pill shadow-sm overflow-hidden" style="background-color: #FFFFFF;">
                    <span class="input-group-text bg-white border-0 text-muted ps-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </span>
                    <input type="text" id="pesquisaTermo" class="form-control border-0 shadow-none fs-6 py-3" placeholder="Pesquisar fórmula ou assunto..." style="color: #2D3748;">
                </div>
            </div>
        </div>

        <div class="row g-4" id="listaTermos">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative card-clicavel" style="background-color: #FFFFFF; border-left: 5px solid #DD6B20 !important;" onclick="abrirFormula('Teorema de Pitágoras', 'a² = b² + c²\n\nUsado para encontrar o comprimento de um dos lados de um triângulo retângulo, conhecendo os outros dois.')">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold mb-0" style="color: #DD6B20; font-size: 1.25rem;">Teorema de Pitágoras</h5>
                            <span class="text-muted" style="opacity: 0.5;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="card-text text-muted flex-grow-1 texto-limitado" style="font-size: 0.95rem; line-height: 1.6;">
                            Usado para encontrar o comprimento de um dos lados de um triângulo retângulo (a² = b² + c²), conhecendo os outros dois.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative card-clicavel" style="background-color: #FFFFFF; border-left: 5px solid #DD6B20 !important;" onclick="abrirFormula('Fórmula de Bhaskara', 'x = (-b ± √(b² - 4ac)) / 2a\n\nMétodo principal utilizado para encontrar as raízes reais de uma equação do segundo grau.')">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold mb-0" style="color: #DD6B20; font-size: 1.25rem;">Fórmula de Bhaskara</h5>
                            <span class="text-muted" style="opacity: 0.5;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="card-text text-muted flex-grow-1 texto-limitado" style="font-size: 0.95rem; line-height: 1.6;">
                            Método principal utilizado para encontrar as raízes reais de uma equação do segundo grau, envolvendo o cálculo do discriminante (delta).
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalNovaFormula" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #2D3748;">Sugerir Nova Fórmula</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNovaFormulaAluno">
                    <div class="modal-body px-4 py-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Assunto / Nome</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" name="nome_termo" placeholder="Ex: Área do Triângulo" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Fórmula e Explicação</label>
                            <textarea class="form-control rounded-3 border-0 bg-light" name="significado_termo" rows="4" placeholder="Digite a fórmula e explique brevemente para que serve..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #DD6B20; color: #FFFFFF;">Enviar Fórmula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLeituraFormula" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background-color: rgba(221, 107, 32, 0.1); color: #DD6B20;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v10.137a.5.5 0 0 0 .77.419C1.76 12.56 3.99 11.732 7.5 11.732c1.38 0 2.583.523 3.217 1.036a.5.5 0 0 0 .786-.441V2.5a.5.5 0 0 0-.11-.312C10.48 1.572 8.913 1.14 8 1.783z"/>
                            </svg>
                        </div>
                        <h4 class="modal-title fw-bold mb-0" id="modalTitulo" style="color: #DD6B20;">Título da Fórmula</h4>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <p id="modalSignificado" class="text-secondary mb-0 fs-5" style="white-space: pre-wrap; line-height: 1.8;"></p>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal" style="color: #2D3748;">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function abrirFormula(titulo, significado) {
            document.getElementById('modalTitulo').innerText = titulo;
            document.getElementById('modalSignificado').innerText = significado;
            var modal = new bootstrap.Modal(document.getElementById('modalLeituraFormula'));
            modal.show();
        }
    </script>
</body>
</html>