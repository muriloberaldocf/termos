<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'gestor') {
    echo json_encode(["success" => false, "message" => "Acesso negado."]);
    exit;
}
$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case 'GET':
        $sql = "SELECT nome_termo, significado_termo as termos_tecnicos from termos";

        $result = $conn -> query ($sql);
        $termos = [];

        if ($result){
            while ($row = $result ->fetch_assoc()){
                $termos[] = $row;
            }
        }
        echo json_encode(["success" => true, "data" => $termos]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->nome_termo) || !isset($data->significado_termo)){
            echo json_encode(["success" => false, "message" => "Dados incompletos. Informe nome_termo e significado_termo."]);
            exit;
            }

            $nome = $conn->real_escape_string(trim($data->nome));
            $id_bloco = (int)$data->id_bloco;

            $sql = "INSERT INTO termos (nome_termo, significado_termo) VALUES ('$nome_termo', '$significado_termo')";

            if($conn->query($sql) === TRUE){
                echo json_encode(["success" => true, "message" => "Ambiente criado com sucesso!", "id_ambiente" => $conn->insert_id]);
            } else {
                echo json_encode(["success" => false, "message" => "Erro ao criar ambiente: " . $conn->error]);
            }
            break;
}

?>