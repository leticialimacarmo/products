<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['id']) || empty($data['id'])) {
    throw new Exception('ID do cliente não foi fornecido.');
  }

  $query = "UPDATE clients 
              SET data_deleted = NOW() 
              WHERE id = :id";
  $stmt = $db->prepare($query);

  $stmt->bindParam(':id', $data['id']);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['error' => 'Nenhum cliente atualizado.']);
  }
} catch (PDOException $e) {
  echo json_encode(['error' => 'Erro ao tentar atualizar o cliente: ' . $e->getMessage()]);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
