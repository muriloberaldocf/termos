<?php
session_start();

// Verifica se está logado (seja Professor ou Sala)
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
    <title>Português - Dicionário Coletivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-clicavel {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
        }
        .card-clicavel:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
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
                <a href="selecionar.php" class="btn btn-light rounded-circle p-2 text-muted shadow-none border-0" style="background-color: #F4F6F8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                </a>
                <h4 class="mb-0 fw-bold" style="color: #3182CE;">Português <span class="badge rounded-pill align-middle ms-2 bg-info text-white" style="font-size: 0.75rem;">Dicionário</span></h4>
            </div>
            
            <div class="d-flex gap-2">
                <?php if($_SESSION['user_perfil'] === 'Sala'): ?>
                <button class="btn fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoTermo" style="background-color: #3182CE; color: #FFFFFF;">
                    <span>+ Novo Termo</span>
                </button>
                <?php endif; ?>
                
                <a href="api/logout.php" class="btn btn-light text-danger fw-bold rounded-pill px-3 shadow-sm border-0 d-flex align-items-center gap-2">
                    <span>Sair</span>
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
                    <input type="text" id="pesquisaTermo" class="form-control border-0 shadow-none fs-6 py-3" placeholder="Pesquisar termo no dicionário...">
                </div>
            </div>
        </div>

        <div class="row g-4" id="listaTermos">
            </div>
    </div>

    <div class="modal fade" id="modalNovoTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Sugerir Nova Palavra</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form id="formNovoTermoAluno">
                    <div class="modal-body px-4 py-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Termo / Palavra</label>
                            <input type="text" class="form-control form-control-lg rounded-3 border-0 bg-light" name="nome_termo" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase text-muted">Significado</label>
                            <textarea class="form-control rounded-3 border-0 bg-light" name="significado_termo" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSalvar" class="btn rounded-pill px-4 fw-bold flex-grow-1" style="background-color: #3182CE; color: #FFFFFF;">Enviar Termo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLeituraTermo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h4 class="modal-title fw-bold" id="modalTitulo" style="color: #3182CE;"></h4>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <p id="modalSignificado" class="text-secondary fs-5" style="line-height: 1.8;"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', carregarTermos);

        function carregarTermos() {
            const lista = document.getElementById('listaTermos');
            // Removemos a filtragem por ID na API (vou te mostrar como abaixo)
            fetch('api/aluno.php?acao=GET_TODOS') 
                .then(res => res.json())
                .then(data => {
                    lista.innerHTML = '';
                    if (data.status === 'sucesso' && data.dados.length > 0) {
                        data.dados.forEach(termo => {
                            lista.innerHTML += `
                                <div class="col-12 col-md-6 col-lg-4 item-termo">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 card-clicavel" 
                                         style="border-left: 5px solid #3182CE !important;"
                                         onclick="abrirTermo('${termo.nome_termo.replace(/'/g, "\\'")}', '${termo.significado_termo.replace(/'/g, "\\'")}')">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-2" style="color: #3182CE;">${termo.nome_termo}</h5>
                                            <p class="text-muted texto-limitado mb-0">${termo.significado_termo}</p>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        lista.innerHTML = '<p class="text-center text-muted">O dicionário está vazio.</p>';
                    }
                });
        }

        document.getElementById('formNovoTermoAluno')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSalvar');
            btn.disabled = true;
            const formData = new FormData(this);
            formData.append('acao', 'POST');

            fetch('api/aluno.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'sucesso') {
                    bootstrap.Modal.getInstance(document.getElementById('modalNovoTermo')).hide();
                    this.reset();
                    carregarTermos();
                } else { alert(data.mensagem); }
            })
            .finally(() => btn.disabled = false);
        });

        function abrirTermo(titulo, significado) {
            document.getElementById('modalTitulo').innerText = titulo;
            document.getElementById('modalSignificado').innerText = significado;
            new bootstrap.Modal(document.getElementById('modalLeituraTermo')).show();
        }

        document.getElementById('pesquisaTermo').addEventListener('input', function() {
            const busca = this.value.toLowerCase();
            document.querySelectorAll('.item-termo').forEach(card => {
                card.style.display = card.innerText.toLowerCase().includes(busca) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>