<?php
// Inicia a sessão para podermos ler quem está logado
session_start();

// Segurança: Se não existir ninguém logado, manda de volta pro login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica o perfil e define para onde os botões vão apontar
if ($_SESSION['user_perfil'] == 'Professor') {
    $linkPortugues = 'prof_pt.php';
    $linkMatematica = 'prof_mat.php';
} else {
    // Se não for professor, assumimos que é a sala (aluno)
    $linkPortugues = 'aluno_pt.php';
    $linkMatematica = 'aluno_mat.php';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards Dicionário - Espaçados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center py-5" style="background-color: #F4F6F8;">

    <div class="position-absolute top-0 end-0 p-4">
        <a href="api/logout.php" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Sair</a>
    </div>

    <div class="container">
        <div class="row justify-content-center g-4">
            
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card shadow border-0 p-5 text-center rounded-4 overflow-hidden position-relative hover-scale" 
                     style="background-color: #3182CE; color: #FFFFFF; min-height: 400px;">
                    
                    <div class="position-absolute opacity-25" style="top: 30px; left: 30px; transform: rotate(-15deg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v10.137a.5.5 0 0 0 .77.419C1.76 12.56 3.99 11.732 7.5 11.732c1.38 0 2.583.523 3.217 1.036a.5.5 0 0 0 .786-.441V2.5a.5.5 0 0 0-.11-.312C10.48 1.572 8.913 1.14 8 1.783z"/>
                        </svg>
                    </div>

                    <div class="position-absolute opacity-25" style="bottom: 30px; right: 30px; transform: rotate(10deg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.258 3h-1.511L6.203 13H7.81l1.108-2.731h3.833L13.847 13h1.626L12.258 3zm-2.911 8.828L11.332 5.67h.117l1.71 6.158H9.347z"/>
                        </svg>
                    </div>

                    <div class="card-body d-flex flex-column justify-content-center position-relative z-1 p-0 mt-4">
                        <h2 class="card-title fw-bold mb-4" style="font-size: 2.5rem;">Português</h2>
                        
                        <p class="card-text fs-5 mb-5 mx-auto" style="max-width: 85%;">
                            Dicionário de termos da língua portuguesa.
                        </p>
                        
                        <div class="mt-auto mb-2">
                            <a href="<?php echo $linkPortugues; ?>" class="btn btn-light rounded-pill shadow-sm fw-bold px-5 py-3 w-100" style="color: #3182CE; font-size: 1.1rem;">
                                Acessar Dicionário
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-5">
                <div class="card shadow border-0 p-5 text-center rounded-4 overflow-hidden position-relative hover-scale" 
                     style="background-color: #DD6B20; color: #FFFFFF; min-height: 400px;">
                    
                    <div class="position-absolute opacity-25" style="top: 30px; left: 30px; transform: rotate(-15deg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                        </svg>
                    </div>

                    <div class="position-absolute opacity-25" style="bottom: 30px; right: 30px; transform: rotate(10deg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.462 2.138a.25.25 0 0 1 .288.351l-9.3 12.31a.25.25 0 0 1-.39-.022L2.538 13.862a.25.25 0 0 1-.288-.351l9.3-12.31a.25.25 0 0 1 .39.022zM2 4.5a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0zm2.5 1.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm6 7a2.5 2.5 0 1 1 5 0 2.5 2.5 0 0 1-5 0zm2.5 1.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                        </svg>
                    </div>

                    <div class="card-body d-flex flex-column justify-content-center position-relative z-1 p-0 mt-4">
                        <h2 class="card-title fw-bold mb-4" style="font-size: 2.5rem;">Matemática</h2>
                        
                        <p class="card-text fs-5 mb-5 mx-auto" style="max-width: 85%;">
                            Dicionário de termos matemáticos.
                        </p>
                        
                        <div class="mt-auto mb-2">
                            <a href="<?php echo $linkMatematica; ?>" class="btn btn-light rounded-pill shadow-sm fw-bold px-5 py-3 w-100" style="color: #DD6B20; font-size: 1.1rem;">
                                Acessar Dicionário
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php if ($_SESSION['user_perfil'] == 'Professor'): ?>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-8 col-lg-10 text-center">
                <a href="gerenciar_turmas.php" class="btn bg-white border-0 shadow-sm rounded-pill py-3 px-5 d-inline-flex align-items-center justify-content-center gap-3 hover-scale text-decoration-none" style="color: #2D3748; min-width: 250px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" style="color: #4A5568;">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                    <span class="fw-bold fs-5">Gerenciar Turmas</span>
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>

</body>
</html>