<?php
session_start();
<<<<<<< HEAD
require_once '../config/database.php';

// Define que a resposta será em formato JSON
header('Content-Type: application/json');

// Captura o JSON enviado pelo Fetch/JS
$dadosBrutos = file_get_contents("php://input");
$data = json_decode($dadosBrutos);

// Verifica se o código de login foi enviado
if (!$data || empty($data->codigoAcesso)) {
    echo json_encode(["success" => false, "message" => "Informe o código de acesso.". $data->codigoAcesso]);


=======
header('Content-Type: application/json; charset=utf-8');

// 1. SEGURANÇA: Verifica se a pessoa está logada
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso negado. Faça login.']);
>>>>>>> ab08d2614bc46b338971c08533e153ed9d0efb98
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

<<<<<<< HEAD
// ---------------------------------------------------------
// ROTA GET - Buscar os termos (Para listar na tela)
// ---------------------------------------------------------
if ($metodo === 'GET' && $acao === 'GET' && !empty($disciplina)) {
=======
<<<<<<< HEAD
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
=======
// 4. ROTA GET - Buscar os termos (A ÚNICA COISA QUE O ALUNO PODE FAZER)
if ($acao === 'GET' && !empty($disciplina)) {
>>>>>>> a388d3f3f77c22b7d4d2ef7e3b35c5156582b5c9
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
>>>>>>> ab08d2614bc46b338971c08533e153ed9d0efb98
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