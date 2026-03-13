<?php
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

            $nome_termo = $conn->real_escape_string(trim($data->nome_termo));
            $significado_termo = $conn->real_escape_string(trim($data->significado_termo));

            $sql = "INSERT INTO termos (nome_termo, significado_termo) VALUES ('$nome_termo', '$significado_termo')";

            if($conn->query($sql) === TRUE){
                echo json_encode(["success" => true, "message" => "Termo criado com sucesso!", "id_termo" => $conn->insert_id]);
            } else {
                echo json_encode(["success" => false, "message" => "Erro ao criar termo: " . $conn->error]);
            }
            break;
}

?>