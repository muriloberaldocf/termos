<?php
// Configurações do Banco de Dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "termos_tecnicos"; // Ajustado para o nome que aparece no seu phpMyAdmin

// Opcional: Se você usa o $conn em outras partes do site (mysqli)
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão mysqli: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// O arquivo api/professor.php vai ignorar o $conn 
// e usar apenas as variáveis acima para criar o PDO.