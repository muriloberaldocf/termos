<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. SEGURANÇA: Verifica se a pessoa está logada
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado. Faça login.']);
    exit;
}

// 2. CONEXÃO COM O BANCO DE DADOS
// Ajuste o nome do arquivo de conexão se o seu for diferente (ex: conexao.php, config.php)
require_once '../conexao.php'; 

// 3. RECEBE OS PARÂMETROS DA URL (Ex: api/aluno.php?acao=GET&disciplina=Matemática)
$acao = $_GET['acao'] ?? '';
$disciplina = $_GET['disciplina'] ?? '';

// 4. ROTA GET - Buscar os termos (A ÚNICA COISA QUE O ALUNO PODE FAZER)
if ($acao === 'GET' && !empty($disciplina)) {
    try {
        // Busca todos os termos daquela disciplina, já em ordem alfabética (A-Z)
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

// Se tentar mandar qualquer outra ação (POST, DELETE, etc) ou esquecer a disciplina:
echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida ou disciplina não informada.']);