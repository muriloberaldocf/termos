<?php
session_start();
// Chama a conexão que cria a variável $conn usando mysqli
require_once '../config/database.php'; 

header('Content-Type: application/json');

// 1. Verificação de Acesso: O professor precisa estar logado!
// Se estiver usando o Postman para testar, comente este bloco IF temporariamente.
if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'Professor') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado.']);
    exit;
}

// 2. Descobre qual ação o frontend ou o Postman está pedindo
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

switch ($acao) {
    case 'GET':
        // Busca as turmas que estão salvas na tabela 'login' com o nível 'Sala'
        $sql = "SELECT id_login AS id_turma, codigo_login AS nome_turma FROM login WHERE nivel_login = 'Sala' ORDER BY codigo_login ASC";
        $result = $conn->query($sql);
        
        $turmas = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $turmas[] = $row;
            }
        }
        echo json_encode(['status' => 'sucesso', 'dados' => $turmas]);
        break;

    case 'POST':
        // Criar uma nova Turma (Sala)
        $nome_turma = $_POST['nome_turma'] ?? '';
        
        if (empty($nome_turma)) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'O nome/código da turma é obrigatório.']);
            exit;
        }

        // Insere na tabela login com nivel = Sala
        $stmt = $conn->prepare("INSERT INTO login (codigo_login, nivel_login) VALUES (?, 'Sala')");
        $stmt->bind_param("s", $nome_turma);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma criada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao criar turma.']);
        }
        $stmt->close();
        break;

    case 'UPDATE':
        // Editar o nome de uma Turma
        $id_turma = $_POST['id_turma'] ?? '';
        $nome_turma = $_POST['nome_turma'] ?? '';
        
        if (empty($id_turma) || empty($nome_turma)) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'ID e Nome da turma são obrigatórios para editar.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE login SET codigo_login = ? WHERE id_login = ? AND nivel_login = 'Sala'");
        // "si" significa que o primeiro param é string (s) e o segundo é inteiro (i)
        $stmt->bind_param("si", $nome_turma, $id_turma);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma atualizada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar turma.']);
        }
        $stmt->close();
        break;

    case 'EXCLUDE':
        // Excluir uma turma
        $id_turma = $_POST['id_turma'] ?? '';
        
        if (empty($id_turma)) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'ID da turma é obrigatório para excluir.']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM login WHERE id_login = ? AND nivel_login = 'Sala'");
        $stmt->bind_param("i", $id_turma);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma excluída com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir turma.']);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}

$conn->close();
?>