<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. CONFIGURAÇÃO (Ajuste se o seu banco não for 'termos')
$host = 'localhost'; 
$dbname = 'termos_tecnicos'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'erro', 'mensagem' => 'Banco: ' . $e->getMessage()]));
}

$acao = $_REQUEST['acao'] ?? '';

if ($acao === 'POST') {
    $nome = $_POST['nome_termo'] ?? '';
    $significado = $_POST['significado_termo'] ?? '';
    $disciplina = $_POST['disciplina'] ?? 'Matematica';
    $id_usuario = $_SESSION['user_id'] ?? null;

    if (!$id_usuario) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Sessão perdida. Faça login novamente.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Tenta inserir o termo
        $stmt = $pdo->prepare("INSERT INTO termos (nome_termo, significado_termo, login_id_login) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $significado, $id_usuario]);
        $id_gerado = $pdo->lastInsertId();

        // Tenta vincular à disciplina
        $stmt2 = $pdo->prepare("INSERT INTO disciplinas (nome_disciplina, termos_id_termo) VALUES (?, ?)");
        $stmt2->execute([$disciplina, $id_gerado]);

        $pdo->commit();
        echo json_encode(['status' => 'sucesso']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro SQL: ' . $e->getMessage()]);
    }
    exit;
}

if ($acao === 'GET') {
    $disc = $_GET['disciplina'] ?? 'Matematica';
    $stmt = $pdo->prepare("SELECT t.* FROM termos t INNER JOIN disciplinas d ON t.id_termo = d.termos_id_termo WHERE d.nome_disciplina = ? ORDER BY t.id_termo DESC");
    $stmt->execute([$disc]);
    echo json_encode(['status' => 'sucesso', 'dados' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    exit;
}