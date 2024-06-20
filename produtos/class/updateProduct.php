<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $id = $input['id'];
  $codigo = $input['codigo'];
  $descricao = $input['descricao'];
  $valor = $input['valor'];
  $fornecedor = $input['fornecedor'];

  $query = "UPDATE products SET codigo = :codigo, descricao = :descricao, valor = :valor, fornecedor = :fornecedor WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':codigo', $codigo);
  $stmt->bindParam(':descricao', $descricao);
  $stmt->bindParam(':valor', $valor);
  $stmt->bindParam(':fornecedor', $fornecedor);

  if ($stmt->execute()) {
    echo json_encode(['message' => 'Produto atualizado com sucesso']);
  } else {
    echo json_encode(['error' => 'Falha ao atualizar produto']);
  }
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
