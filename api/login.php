<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../config/database.php';

// Define que a resposta será em formato JSON
header('Content-Type: application/json');

// Captura o JSON enviado pelo Fetch/JS
$dadosBrutos = file_get_contents("php://input");
$data = json_decode($dadosBrutos);

// Verifica se o código de login foi enviado
if (!$data || empty($data->codigoAcesso)) {
    echo json_encode(["success" => false, "message" => "Informe o código de acesso.". $data->codigoAcesso]);


    exit;
}

// Limpa a entrada do usuário
$codigo_login = $conn->real_escape_string(trim($data->codigoAcesso));

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

    // Retorna SUCESSO e o perfil (o seu JS vai ler isso e redirecionar lá no front)
    echo json_encode(["success" => true, "perfil" => $user['nivel_login']]);
    exit;

} else {
    // Retorna ERRO para o JavaScript exibir na tela
    echo json_encode(["success" => false, "message" => "Código incorreto. Tente novamente."]);
    exit;
}
?>