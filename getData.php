<?php
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$caminho = __DIR__ . '/banco.sqlite';

try {
    // Conectar ao banco de dados SQLite
    $pdo = new PDO("sqlite:" . $caminho);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL para consultar dados
    $query = "SELECT nome, email FROM usuarios LIMIT 2"; // Ajuste a consulta conforme necessário

    // Executar a consulta
    $stmt = $pdo->query($query);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
