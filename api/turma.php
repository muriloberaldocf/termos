<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. SEGURANÇA: Verifica se a pessoa está logada


// 2. CONEXÃO COM O BANCO DE DADOS
require_once '../config/database.php'; 

$metodo = $_SERVER['REQUEST_METHOD'];
$acao = $_REQUEST['acao'] ?? '';

// ---------------------------------------------------------
// ROTA GET - Listar todas as turmas
// ---------------------------------------------------------
if ($metodo === 'GET' && $acao === 'GET') {
    $stmt = $conn->prepare("SELECT id_turma, nome_turma FROM turmas ORDER BY nome_turma ASC");
    if ($stmt) {
        $stmt->execute();
        $resultado = $stmt->get_result();
        $turmas = $resultado->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['status' => 'sucesso', 'dados' => $turmas]);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro na consulta: ' . $conn->error]);
    }
    exit;
}

// ---------------------------------------------------------
// ROTA POST - Criar uma nova turma
// ---------------------------------------------------------
if ($metodo === 'POST' && $acao === 'POST') {
    $nome_turma = trim($_POST['nome_turma'] ?? '');

    if (empty($nome_turma)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'O nome da turma é obrigatório.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO turmas (nome_turma) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $nome_turma); // "s" significa String
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma criada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao criar a turma: ' . $stmt->error]);
        }
    }
    exit;
}

// ---------------------------------------------------------
// ROTA UPDATE - Editar o nome de uma turma
// ---------------------------------------------------------
if ($metodo === 'POST' && $acao === 'UPDATE') {
    $id_turma = $_POST['id_turma'] ?? '';
    $nome_turma = trim($_POST['nome_turma'] ?? '');

    if (empty($id_turma) || empty($nome_turma)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'ID e Nome da turma são obrigatórios para editar.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE turmas SET nome_turma = ? WHERE id_turma = ?");
    if ($stmt) {
        $stmt->bind_param("si", $nome_turma, $id_turma); // "s" = String, "i" = Integer
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma atualizada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar a turma.']);
        }
    }
    exit;
}

// ---------------------------------------------------------
// ROTA EXCLUDE - Deletar uma turma
// ---------------------------------------------------------
if ($metodo === 'POST' && $acao === 'EXCLUDE') {
    $id_turma = $_POST['id_turma'] ?? '';

    if (empty($id_turma)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'ID da turma é obrigatório para excluir.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM turmas WHERE id_turma = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id_turma);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Turma excluída com sucesso!']);
        } else {
            // Código 1451 no MySQLi significa erro de chave estrangeira (turma em uso)
            if ($conn->errno == 1451) {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Não é possível excluir esta turma pois já existem registros vinculados a ela.']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir: ' . $stmt->error]);
            }
        }
    }
    exit;
}

// Se chegar até aqui, mandou uma ação que não existe
echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);