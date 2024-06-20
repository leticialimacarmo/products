<?php

require_once '../../common/db.php';


header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $id = $input['id'];
  $data_deleted = date('Y-m-d H:i:s');

  $query = "UPDATE products SET data_deleted = :data_deleted WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':data_deleted', $data_deleted);

  if ($stmt->execute()) {
    echo json_encode(['message' => 'Produto excluído com sucesso']);
  } else {
    echo json_encode(['error' => 'Falha ao excluir produto']);
  }
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
