<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $codigo = $input['codigo'];
  $descricao = $input['descricao'];
  $valor = $input['valor'];
  $fornecedor = $input['fornecedor'];

  $query = "INSERT INTO products (codigo, descricao, valor, fornecedor) VALUES (:codigo, :descricao, :valor, :fornecedor)";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':codigo', $codigo);
  $stmt->bindParam(':descricao', $descricao);
  $stmt->bindParam(':valor', $valor);
  $stmt->bindParam(':fornecedor', $fornecedor);

  if ($stmt->execute()) {
    echo json_encode(['message' => 'Produto registrado com sucesso']);
  } else {
    echo json_encode(['error' => 'Falha ao registrar produto']);
  }
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
