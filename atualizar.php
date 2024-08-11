<?php
header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$caminho = __DIR__ . '/banco.sqlite';

try {
    // Conectar ao banco de dados SQLite
    $pdo = new PDO("sqlite:" . $caminho);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obter os dados do POST
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (!$id || !$nome || !$email || !$senha) {
        echo json_encode(['error' => 'Dados insuficientes para atualizar.']);
        exit();
    }

    // Preparar a consulta SQL para atualização
    $query = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
    $stmt = $pdo->prepare($query);

    // Bind dos parâmetros
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

    // Executar a consulta
    $stmt->execute();

    // Verificar se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => 'Usuário atualizado com sucesso.']);
    } else {
        echo json_encode(['error' => 'Nenhuma alteração foi feita.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
