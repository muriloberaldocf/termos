<?php
session_start();
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
        body { background-color: #F4F6F8; color: #2D3748; }
        .card-clicavel {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
            border-left: 5px solid #DD6B20 !important;
        }
        .card-clicavel:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .texto-limitado {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .btn-laranja { background-color: #DD6B20; color: white; border: none; }
        .btn-laranja:hover { background-color: #c0561a; color: white; }
    </style>
</head>
<body>

    <nav class="navbar shadow-sm py-3 bg-white">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="selecionar.php" class="btn btn-light rounded-circle shadow-none border-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
                </a>
                <h4 class="mb-0 fw-bold" style="color: #DD6B20;">Matemática <span class="badge rounded-pill bg-info text-white ms-2" style="font-size: 0.7rem;">Aluno</span></h4>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-laranja fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNova">
                    + Nova Fórmula
                </button>
                <a href="api/logout.php" class="btn btn-light text-danger fw-bold rounded-pill px-3 border-0">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row mb-5 justify-content-center">
            <div class="col-12 col-md-8">
                <div class="input-group input-group-lg rounded-pill shadow-sm overflow-hidden bg-white">
                    <span class="input-group-text bg-white border-0 ps-4 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                    </span>
                    <input type="text" id="inputBusca" class="form-control border-0 shadow-none fs-6 py-3" placeholder="O que você está procurando?">
                </div>
            </div>
        </div>

        <div class="row g-4" id="containerCards">
            </div>
    </div>

    <div class="modal fade" id="modalNova" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form id="formSugerir">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="fw-bold">Sugerir Nova Fórmula</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="disciplina" value="Matematica">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOME DA FÓRMULA</label>
                            <input type="text" class="form-control bg-light border-0" name="nome_termo" placeholder="Ex: Teorema de Pitágoras" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">EXPLICAÇÃO</label>
                            <textarea class="form-control bg-light border-0" name="significado_termo" rows="4" placeholder="Descreva a fórmula e como usar..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSalvar" class="btn btn-laranja rounded-pill px-4 fw-bold">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pt-4 px-4">
                    <h4 class="fw-bold" id="verTitulo" style="color: #DD6B20;"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p id="verTexto" class="fs-5 text-secondary" style="white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const API = 'api/aluno.php'; // Caminho corrigido para não dar 404

        function carregar() {
            fetch(`${API}?acao=GET&disciplina=Matematica`)
                .then(res => res.json())
                .then(res => {
                    const container = document.getElementById('containerCards');
                    if (res.status === 'sucesso') {
                        container.innerHTML = res.dados.map(item => `
                            <div class="col-12 col-md-6 col-lg-4 card-item">
                                <div class="card h-100 border-0 shadow-sm rounded-4 card-clicavel" 
                                     onclick="mostrar('${item.nome_termo.replace(/'/g, "\\'")}', '${item.significado_termo.replace(/'/g, "\\'")}')">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-2" style="color: #DD6B20;">${item.nome_termo}</h5>
                                        <p class="text-muted texto-limitado mb-0">${item.significado_termo}</p>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        container.innerHTML = `<p class="text-center text-muted">${res.mensagem}</p>`;
                    }
                })
                .catch(err => console.error("Erro ao carregar:", err));
        }

        document.getElementById('formSugerir').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSalvar');
            btn.disabled = true;

            const dados = new FormData(this);
            dados.append('acao', 'POST');

            fetch(API, { method: 'POST', body: dados })
                .then(res => res.json())
                .then(res => {
                    if(res.status === 'sucesso') {
                        bootstrap.Modal.getInstance(document.getElementById('modalNova')).hide();
                        this.reset();
                        carregar();
                    } else {
                        alert("Atenção: " + res.mensagem);
                    }
                })
                .catch(err => alert("Erro técnico. Verifique se o banco de dados existe."))
                .finally(() => btn.disabled = false);
        });

        function mostrar(t, s) {
            document.getElementById('verTitulo').innerText = t;
            document.getElementById('verTexto').innerText = s;
            new bootstrap.Modal(document.getElementById('modalVer')).show();
        }

        document.getElementById('inputBusca').addEventListener('input', function() {
            const busca = this.value.toLowerCase();
            document.querySelectorAll('.card-item').forEach(c => {
                c.style.display = c.innerText.toLowerCase().includes(busca) ? 'block' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', carregar);
    </script>
</body>
</html>