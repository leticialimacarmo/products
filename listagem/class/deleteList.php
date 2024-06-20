<?php

require_once '../../common/db.php';


header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $query = "UPDATE sales SET data_deleted = NOW() WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':id', $input['id']);
  $stmt->execute();

  echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
