<?php
session_start();

// 1. ERROS (Desative isso após funcionar para não quebrar o JSON)
ini_set('display_errors', 0); 
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

// 2. CONEXÃO (Verifique se as variáveis batem com seu banco)
$host = 'localhost'; 
$dbname = 'termos'; // Nome do seu banco
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro de conexão']);
    exit;
}

// 3. PEGA A AÇÃO
$acao = $_REQUEST['acao'] ?? '';

switch ($acao) {
    case 'POST':
        $nome = $_POST['nome_termo'] ?? '';
        $significado = $_POST['significado_termo'] ?? '';
        $disciplina = $_POST['disciplina'] ?? 'Matematica';
        $id_usuario = $_SESSION['user_id'] ?? 0;

        if (!$nome || !$significado || $id_usuario == 0) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos ou deslogado']);
            exit;
        }

        try {
            $pdo->beginTransaction();
            // Insere o termo
            $stmt = $pdo->prepare("INSERT INTO termos (nome_termo, significado_termo, login_id_login) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $significado, $id_usuario]);
            $id_gerado = $pdo->lastInsertId();

            // VINCULA À DISCIPLINA (Isso é o que faz o Professor ver!)
            $stmt2 = $pdo->prepare("INSERT INTO disciplinas (nome_disciplina, termos_id_termo) VALUES (?, ?)");
            $stmt2->execute([$disciplina, $id_gerado]);

            $pdo->commit();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Termo enviado!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    case 'GET':
        $disc = $_GET['disciplina'] ?? 'Matematica';
        try {
            // Puxa TUDO da disciplina, não importa quem postou
            $sql = "SELECT t.id_termo, t.nome_termo, t.significado_termo 
                    FROM termos t 
                    INNER JOIN disciplinas d ON t.id_termo = d.termos_id_termo 
                    WHERE d.nome_disciplina = ? 
                    ORDER BY t.id_termo DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$disc]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['status' => 'sucesso', 'dados' => $dados]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Acao invalida: ' . $acao]);
        break;
}