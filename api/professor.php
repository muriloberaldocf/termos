<?php
// 1. CONFIGURAÇÕES INICIAIS
session_start();

// Desativamos a exibição de erros na tela para não corromper o JSON
// Mas o log de erros continua funcionando internamente no servidor.
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Iniciamos um buffer de saída para descartar qualquer "lixo" (espaços ou avisos)
ob_start();

require_once '../config/database.php'; 

// Forçamos o cabeçalho para JSON
header('Content-Type: application/json; charset=utf-8');

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    ob_clean();
    echo json_encode(['status' => 'erro', 'mensagem' => 'Falha na conexão com o banco.']);
    exit;
}

// 2. DEFINIÇÃO DA AÇÃO
$acao = $_REQUEST['acao'] ?? ''; 

// 3. CONTROLE DE ACESSO
if (in_array($acao, ['POST', 'UPDATE', 'EXCLUDE'])) {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_perfil'] !== 'Professor') {
        ob_clean();
        echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado.']);
        exit;
    }
}

// 4. ROTEAMENTO (CRUD)
switch ($acao) {

    case 'GET':
        $disciplina = $_GET['disciplina'] ?? '';
        try {
            // INNER JOIN para garantir que só pegamos termos da disciplina correta
            $sql = "SELECT t.id_termo, t.nome_termo, t.significado_termo 
                    FROM termos t 
                    INNER JOIN disciplinas d ON t.id_termo = d.termos_id_termo 
                    WHERE d.nome_disciplina = ? ORDER BY t.nome_termo ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$disciplina]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            ob_clean();
            echo json_encode(['status' => 'sucesso', 'dados' => $dados]);
        } catch (PDOException $e) {
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao buscar: ' . $e->getMessage()]);
        }
        break;

    case 'POST':
        $nome = $_POST['nome_termo'] ?? '';
        $significado = $_POST['significado_termo'] ?? '';
        $disciplina = $_POST['disciplina'] ?? '';
        $login_id = $_SESSION['user_id']; 

        if (!$nome || !$significado || !$disciplina) {
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos.']);
            exit;
        }

        try {
            $pdo->beginTransaction();
            
            // 1. Insere o termo (Verifique se a coluna login_id_login existe na sua tabela)
            $stmt = $pdo->prepare("INSERT INTO termos (nome_termo, significado_termo, login_id_login) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $significado, $login_id]);
            $id_termo = $pdo->lastInsertId();

            // 2. Relaciona com a disciplina
            $stmtDisc = $pdo->prepare("INSERT INTO disciplinas (nome_disciplina, termos_id_termo) VALUES (?, ?)");
            $stmtDisc->execute([$disciplina, $id_termo]);

            $pdo->commit();
            ob_clean();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Cadastrado com sucesso!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar: ' . $e->getMessage()]);
        }
        break;

    case 'UPDATE':
        $id = $_POST['id'] ?? '';
        $nome = $_POST['nome_termo'] ?? '';
        $significado = $_POST['significado_termo'] ?? '';

        if (!$id || !$nome || !$significado) {
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos.']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE termos SET nome_termo = ?, significado_termo = ? WHERE id_termo = ?");
            $stmt->execute([$nome, $significado, $id]);
            
            ob_clean();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Atualizado com sucesso!']);
        } catch (PDOException $e) {
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao editar: ' . $e->getMessage()]);
        }
        break;

    case 'EXCLUDE':
        $id = $_POST['id'] ?? '';
        
        if (!$id) {
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'ID inválido.']);
            exit;
        }

        try {
            $pdo->beginTransaction();
            // Remove primeiro da disciplina (chave estrangeira) e depois do termo
            $stmt1 = $pdo->prepare("DELETE FROM disciplinas WHERE termos_id_termo = ?");
            $stmt1->execute([$id]);
            $stmt2 = $pdo->prepare("DELETE FROM termos WHERE id_termo = ?");
            $stmt2->execute([$id]);
            
            $pdo->commit();
            ob_clean();
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Excluído com sucesso!']);
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            ob_clean();
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir: ' . $e->getMessage()]);
        }
        break;

    default:
        ob_clean();
        echo json_encode(['status' => 'erro', 'mensagem' => 'Ação desconhecida.']);
        break;
}

// Envia o conteúdo do buffer e encerra
ob_end_flush();