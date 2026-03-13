<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../config/database.php';

// Verifica se o código de login foi enviado pelo formulário
if (empty($_POST['codigo_login'])) {
    header("Location: ../login.php?erro=Informe o código de acesso.");
    exit;
}

// Limpa a entrada do usuário
$codigo_login = $conn->real_escape_string(trim($_POST['codigo_login']));

// Busca o usuário na tabela 'login'
$sql = "SELECT id_login, codigo_login, nivel_login 
        FROM login 
        WHERE codigo_login = '$codigo_login' 
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Salva na sessão
    $_SESSION['user_id'] = $user['id_login'];
    $_SESSION['user_perfil'] = $user['nivel_login']; 

    // Redireciona dependendo do perfil
    if ($user['nivel_login'] === 'professor') {
        header("Location: ../selecionar.php");
    } else {
        header("Location: ../selecionar.php");
    }
    exit;

} else {
    // Redireciona de volta para o login com a mensagem de erro
    header("Location: ../login.php?erro=Código incorreto. Tente novamente.");
    exit;
}
?>