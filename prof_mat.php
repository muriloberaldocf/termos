<?php
session_start();

// Verifica se está logado e se é Professor
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user_perfil'] !== 'Professor') {
    header("Location: aluno_mat.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matemática - Área do Professor</title>
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

        body {
            background-color: #F4F6F8;
            color: #2D3748;
        }
    </style>
</head>
<body class="min-vh-100">

    <nav class="navbar shadow-sm py-3" style="background-color: #FFFFFF;">
        <div class="container d-flex justify-content-between align-items-center">
            
            <div class="d-flex align-items-center gap-3">
                <a href="selecionar.php" class="btn btn-light rounded-circle p-2 text-muted shadow-none border-0" style="background-color: #F4F6F8;" title="Voltar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                </a>
                <h4 class="mb-0 fw-bold" style="color: #E53E3E;">Matemática</h4>
            </div>
            
            <div class="d-flex gap-2 align-items-center">
                <a href="gerenciar_turmas.php" class="btn btn-outline-secondary fw-bold rounded-pill px-3 shadow-sm d-none d-md-block">
                    Gerenciar Turmas
                </a>

                <button class="btn fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoTermo" style="background-color: #E53E3E; color: #FFFFFF;">
                    <span class="d-none d-sm-inline">+ Novo Termo</span>
                    <span class="d-inline d-sm-none">+</span> 
                </button>

                <a href="api/logout.php" class="btn btn-light text-danger fw-bold rounded-pill px-3 shadow-sm border-0 d-flex align-items-center gap-2">
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
                    <input type="text" id="pesquisaTermo" class="form-control border-0 shadow-none fs-6 py-3" placeholder="Pesquisar termo ou conceito...">
                </div>
            </div>
        </div>

        <div class="row g-4" id="listaTermos">
            </div>
    </div>

    <div class="modal fade" id="modalLeituraTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background-color: rgba(229, 62, 62, 0.1); color: #E53E3E;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v10.137a.5.5 0 0 0 .77.419C1.76 12.56 3.99 11.732 7.5 11.732c1.38 0 2.583.523 3.217 1.036a.5.5 0 0 0 .786-.441V2.5a.5.5 0 0 0-.11-.312C10.48 1.572 8.913 1.14 8 1.783z"/>
                            </svg>
                        </div>
                        <h4 class="modal-title fw-bold mb-0" id="modalTituloLeitura" style="color: #E53E3E;">Título</h4>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <p id="modalSignificadoLeitura" class="text-secondary mb-0 fs-5" style="white-space: pre-wrap; line-height: 1.8;"></p>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovoTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Adicionar Termo</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNovoTermo">
                    <div class="modal-body px-4 py-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Termo / Palavra</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" name="nome_termo" placeholder="Ex: Hipotenusa" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Significado</label>
                            <textarea class="form-control rounded-3 border-0 bg-light" name="significado_termo" rows="4" placeholder="Digite a definição..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #E53E3E; color: #FFFFFF;">Salvar Termo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Editar Termo</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarTermo">
                    <div class="modal-body px-4 py-4">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Termo / Palavra</label>
                            <input type="text" id="edit_nome" class="form-control form-control-lg rounded-3 border-0 bg-light" name="nome_termo" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Significado</label>
                            <textarea id="edit_significado" class="form-control rounded-3 border-0 bg-light" name="significado_termo" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #E53E3E; color: #FFFFFF;">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExcluirTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body p-5 text-center">
                    <div class="text-danger mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                    </div>
                    <h4 class="fw-bold mb-3">Excluir Termo?</h4>
                    <p class="text-muted mb-4">Tem certeza que deseja apagar esta palavra? Esta ação não poderá ser desfeita.</p>
                    <form id="formExcluirTermo">
                        <input type="hidden" id="delete_id" name="id">
                        <div class="d-flex gap-3 justify-content-center">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Sim, Excluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const DISCIPLINA_ATUAL = 'Matemática';
        let todosOsTermos = []; 

        document.addEventListener('DOMContentLoaded', () => {
            carregarTermos();
        });

        // 1. BARRA DE PESQUISA (Tempo Real)
        document.getElementById('pesquisaTermo').addEventListener('input', aplicarFiltros);

        // 2. FILTRAR DADOS
        function aplicarFiltros() {
            const termoBusca = document.getElementById('pesquisaTermo').value.toLowerCase();
            
            const filtrados = todosOsTermos.filter(termo => {
                return termo.nome_termo.toLowerCase().includes(termoBusca);
            });

            renderizarCards(filtrados);
        }

        // 3. BUSCAR DADOS DO BANCO
        async function carregarTermos() {
            try {
                const response = await fetch(`api/professor.php?acao=GET&disciplina=${DISCIPLINA_ATUAL}`);
                const resultado = await response.json();

                if (resultado.status === 'sucesso') {
                    todosOsTermos = resultado.dados;
                    aplicarFiltros(); 
                }
            } catch (erro) {
                console.error("Erro ao buscar dados:", erro);
            }
        }

        // 4. RENDERIZAR CARDS
        function renderizarCards(termos) {
            const lista = document.getElementById('listaTermos');
            lista.innerHTML = ''; 

            if (termos.length === 0) {
                lista.innerHTML = `<div class="col-12 text-center text-muted mt-4"><p>Nenhum termo encontrado.</p></div>`;
                return;
            }

            termos.forEach(termo => {
                const sigEscapado = termo.significado_termo.replace(/'/g, "\\'");
                const nomeEscapado = termo.nome_termo.replace(/'/g, "\\'");

                lista.innerHTML += `
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 card-clicavel" 
                             style="background-color: #FFFFFF; border-left: 5px solid #E53E3E !important;" 
                             onclick="abrirTermo('${nomeEscapado}', '${sigEscapado}')">
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="card-title fw-bold mb-0" style="color: #E53E3E;">${termo.nome_termo}</h5>
                                <p class="card-text text-muted flex-grow-1 texto-limitado mt-3">
                                    ${termo.significado_termo}
                                </p>
                                <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill fw-bold px-3" 
                                            onclick="event.stopPropagation(); prepararEdicao(${termo.id_termo}, '${nomeEscapado}', '${sigEscapado}')">
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill fw-bold px-3" 
                                            onclick="event.stopPropagation(); prepararExclusao(${termo.id_termo})">
                                        Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // --- CRUD ACTIONS ---

        document.getElementById('formNovoTermo').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('acao', 'POST');
            formData.append('disciplina', DISCIPLINA_ATUAL);

            try {
                const res = await fetch('api/professor.php', { method: 'POST', body: formData });
                const data = await res.json();
                if(data.status === 'sucesso') {
                    bootstrap.Modal.getInstance(document.getElementById('modalNovoTermo')).hide();
                    this.reset();
                    carregarTermos();
                } else { alert("Erro: " + data.mensagem); }
            } catch (erro) { console.error(erro); }
        };

        document.getElementById('formEditarTermo').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('acao', 'UPDATE');
            const res = await fetch('api/professor.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.status === 'sucesso') {
                bootstrap.Modal.getInstance(document.getElementById('modalEditarTermo')).hide();
                carregarTermos();
            } else { alert(data.mensagem); }
        };

        document.getElementById('formExcluirTermo').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('acao', 'EXCLUDE');
            const res = await fetch('api/professor.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.status === 'sucesso') {
                bootstrap.Modal.getInstance(document.getElementById('modalExcluirTermo')).hide();
                carregarTermos();
            } else { alert(data.mensagem); }
        };

        function abrirTermo(titulo, significado) {
            document.getElementById('modalTituloLeitura').innerText = titulo;
            document.getElementById('modalSignificadoLeitura').innerText = significado;
            new bootstrap.Modal(document.getElementById('modalLeituraTermo')).show();
        }

        function prepararEdicao(id, nome, significado) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_significado').value = significado;
            new bootstrap.Modal(document.getElementById('modalEditarTermo')).show();
        }

        function prepararExclusao(id) {
            document.getElementById('delete_id').value = id;
            new bootstrap.Modal(document.getElementById('modalExcluirTermo')).show();
        }
    </script>
</body>
</html>