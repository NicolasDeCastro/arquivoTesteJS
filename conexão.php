<?php
header('Content-Type: application/json');

$caminho = __DIR__ . '/banco.sqlite';

try {
    $pdo = new PDO("sqlite:" . $caminho);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se um ID foi passado na URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id) {
        // Consulta para um único usuário por ID
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        // Consulta para todos os usuários
        $query = "SELECT * FROM usuarios";
        $stmt = $pdo->query($query);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
