<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Captura o JSON enviado pelo Fetch/JS
$dadosBrutos = file_get_contents("php://input");
$data = json_decode($dadosBrutos);

// Alterado: agora esperamos 'codigo_login' em vez de 'email' e 'senha'
if (!$data || !isset($data->codigo_login)) {
    echo json_encode(["success" => false, "message" => "Dados inválidos. Informe o código de login."]);
    exit;
}

// Limpa a entrada do usuário
$codigo_login = $conn->real_escape_string(trim($data->codigo_login));

// Busca o usuário na tabela 'login' da sua modelagem
$sql = "SELECT id_login, codigo_login, nivel_login 
        FROM login 
        WHERE codigo_login = '$codigo_login' 
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Como não há campo de senha na modelagem, o login é aprovado se o código existir
    $_SESSION['user_id'] = $user['id_login'];
    $_SESSION['user_perfil'] = $user['nivel_login']; // 'professor' ou 'aluno'

    echo json_encode(["success" => true, "perfil" => $user['nivel_login']]);
    exit;

} else {
    echo json_encode(["success" => false, "message" => "Código de login não encontrado."]);
    exit;
}
?>