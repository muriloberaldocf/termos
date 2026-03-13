<?php
session_start();

// 1. Verifica se a pessoa está logada. Se não, manda pro login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. A "CATRACA": Verifica se o usuário NÃO é um Professor. 
// Se for aluno, manda ele de volta pra tela de selecionar e para de carregar a página.
if ($_SESSION['user_perfil'] !== 'Professor') {
    header("Location: selecionar.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turmas - Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100" style="background-color: #F4F6F8; color: #2D3748;">

    <nav class="navbar shadow-sm py-3" style="background-color: #FFFFFF;">
        <div class="container d-flex justify-content-between align-items-center">
            
            <div class="d-flex align-items-center gap-3">
                <a href="selecionar.php" class="btn btn-light rounded-circle p-2 text-muted shadow-none border-0" style="background-color: #F4F6F8;" title="Voltar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                </a>
                <h4 class="mb-0 fw-bold" style="color: #2D3748;">Gerenciar Turmas <span class="badge rounded-pill align-middle ms-2 bg-warning text-dark" style="font-size: 0.75rem;">Modo Professor</span></h4>
            </div>
            
            <div class="d-flex gap-2">
                <button class="btn fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaTurma" style="background-color: #DD6B20; color: #FFFFFF;">
                    <span class="d-none d-sm-inline">+ Nova Turma</span>
                    <span class="d-inline d-sm-none">+</span>
                </button>
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
                    <input type="text" id="pesquisaTurma" class="form-control border-0 shadow-none fs-6 py-3" placeholder="Pesquisar turma ou código..." style="color: #2D3748;">
                </div>
            </div>
        </div>

        <div class="row g-4" id="listaTurmas">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative hover-shadow" style="background-color: #FFFFFF;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold mb-0" style="color: #DD6B20; font-size: 1.25rem;">3º Ano A</h5>
                            
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-light text-primary border-0 rounded-circle p-2 shadow-none" title="Editar Turma" data-bs-toggle="modal" data-bs-target="#modalEditarTurma">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </button>
                                <button class="btn btn-sm btn-light text-danger border-0 rounded-circle p-2 shadow-none" title="Excluir Turma" data-bs-toggle="modal" data-bs-target="#modalExcluirTurma">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-3 mb-2 rounded-3 text-center shadow-sm" style="background-color: #F4F6F8;">
                            <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Código de Entrada</span>
                            <span class="text-dark font-monospace fs-5">SENHA123</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>

    <div class="modal fade" id="modalNovaTurma" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #2D3748;">Adicionar Turma</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNovaTurma">
                    <div class="modal-body px-4 py-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nome da Turma</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" name="nome_turma" placeholder="Ex: 1º Ano B" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Código de Login</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" name="codigo_login" placeholder="Ex: CODIGO456" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #DD6B20; color: #FFFFFF;">Salvar Turma</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarTurma" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" style="color: #2D3748;">Editar Turma</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarTurma">
                    <input type="hidden" name="id_turma" id="edit_id_turma">
                    
                    <div class="modal-body px-4 py-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nome da Turma</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" id="edit_nome_turma" name="nome_turma" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Código de Login</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" id="edit_codigo_login" name="codigo_login" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #3182CE; color: #FFFFFF;">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExcluirTurma" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4 text-center p-4">
                <div class="mb-3" style="color: #E53E3E;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
                <h5 class="fw-bold mb-2" style="color: #2D3748;">Excluir Turma?</h5>
                <p class="text-muted mb-4 small">Você realmente deseja excluir esta turma? Essa ação não pode ser desfeita e os alunos perderão o acesso.</p>
                <form id="formExcluirTurma">
                    <input type="hidden" name="id_turma" id="delete_id_turma">
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold flex-grow-1">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>