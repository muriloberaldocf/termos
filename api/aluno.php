<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. SEGURANÇA: Verifica se a pessoa está logada
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado. Faça login.']);
    exit;
}

// 2. CONEXÃO COM O BANCO DE DADOS
// Ajuste o nome do arquivo de conexão se o seu for diferente (ex: conexao.php, db.php)
require_once '../conexao.php'; 

// 3. IDENTIFICA A AÇÃO E A DISCIPLINA
// Como temos GET e POST, usamos $_REQUEST para pegar de qualquer um dos dois métodos
$metodo = $_SERVER['REQUEST_METHOD'];
$acao = $_REQUEST['acao'] ?? '';
$disciplina = $_REQUEST['disciplina'] ?? '';

// ---------------------------------------------------------
// ROTA GET - Buscar os termos (Para listar na tela)
// ---------------------------------------------------------
if ($metodo === 'GET' && $acao === 'GET' && !empty($disciplina)) {
    try {
        $stmt = $pdo->prepare("SELECT id_termo, nome_termo, significado_termo FROM termos WHERE disciplina = :disciplina ORDER BY nome_termo ASC");
        $stmt->bindParam(':disciplina', $disciplina);
        $stmt->execute();
        
        $termos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['status' => 'sucesso', 'dados' => $termos]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao buscar termos: ' . $e->getMessage()]);
    }
    exit;
}

// ---------------------------------------------------------
// ROTA POST - Adicionar novo termo (Aluno colaborando)
// ---------------------------------------------------------
if ($metodo === 'POST' && $acao === 'POST' && !empty($disciplina)) {
    $nome_termo = trim($_POST['nome_termo'] ?? '');
    $significado_termo = trim($_POST['significado_termo'] ?? '');

    // Validação básica
    if (empty($nome_termo) || empty($significado_termo)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO termos (nome_termo, significado_termo, disciplina) VALUES (:nome, :significado, :disciplina)");
        $stmt->bindParam(':nome', $nome_termo);
        $stmt->bindParam(':significado', $significado_termo);
        $stmt->bindParam(':disciplina', $disciplina);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Termo adicionado com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao adicionar o termo.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()]);
    }
    exit;
}

// Se tentar mandar qualquer outra ação (DELETE, UPDATE, etc) ou esquecer a disciplina:
echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida ou disciplina não informada.']);