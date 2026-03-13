<?php
session_start();

// Exibe erros para facilitar o debug (pode desativar quando for lançar o site oficial)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// 1. CONEXÃO COM O BANCO
$host = 'localhost';
$dbname = 'termos_tecnicos';
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

// 2. DEFINIÇÃO DA AÇÃO
$acao = $_REQUEST['acao'] ?? ''; 

// 3. CONTROLE DE ACESSO (Travas de Segurança)
if (in_array($acao, ['POST', 'UPDATE', 'EXCLUDE'])) {
    // Se tentar salvar, editar ou excluir, TEM que estar logado e TEM que ser Professor
    if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'Professor') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado. Somente professores podem fazer alterações.']);
        exit;
    }
}

// 4. ROTEAMENTO (CRUD)
switch ($acao) {

    case 'GET':
        $disciplina = $_GET['disciplina'] ?? '';
        try {
            $sql = "SELECT t.id_termo, t.nome_termo, t.significado_termo 
                    FROM termos t 
                    INNER JOIN disciplinas d ON t.id_termo = d.termos_id_termo 
                    WHERE d.nome_disciplina = ? ORDER BY t.nome_termo ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$disciplina]);
            echo json_encode(['status' => 'sucesso', 'dados' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    case 'POST':
        $nome = $_POST['nome_termo'] ?? '';
        $significado = $_POST['significado_termo'] ?? '';
        $disciplina = $_POST['disciplina'] ?? '';
        
        // Agora pegamos o ID real de quem está logado!
        $login_id = $_SESSION['user_id']; 

        if (!$nome || !$significado || !$disciplina) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos.']);
            exit;
        }

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO termos (nome_termo, significado_termo, login_id_login) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $significado, $login_id]);
            $id_termo = $pdo->lastInsertId();

            $stmtDisc = $pdo->prepare("INSERT INTO disciplinas (nome_disciplina, termos_id_termo) VALUES (?, ?)");
            $stmtDisc->execute([$disciplina, $id_termo]);

            $pdo->commit();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Cadastrado com sucesso!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    case 'UPDATE':
        $id = $_POST['id'] ?? '';
        $nome = $_POST['nome_termo'] ?? '';
        $significado = $_POST['significado_termo'] ?? '';

        if (!$id || !$nome || !$significado) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos para edição.']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE termos SET nome_termo = ?, significado_termo = ? WHERE id_termo = ?");
            $stmt->execute([$nome, $significado, $id]);
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Atualizado com sucesso!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    case 'EXCLUDE':
        $id = $_POST['id'] ?? '';
        
        if (!$id) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'ID não informado.']);
            exit;
        }

        try {
            $pdo->beginTransaction();
            $stmt1 = $pdo->prepare("DELETE FROM disciplinas WHERE termos_id_termo = ?");
            $stmt1->execute([$id]);
            $stmt2 = $pdo->prepare("DELETE FROM termos WHERE id_termo = ?");
            $stmt2->execute([$id]);
            $pdo->commit();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Excluído com sucesso!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação inválida.']);
        break;
}