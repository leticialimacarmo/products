<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $query = "UPDATE sales SET cliente = :cliente, tipoPagamento = :tipoPagamento, valorIntegral = :valorIntegral WHERE id = :id";
  $stmt = $db->prepare($query);
  $stmt->bindParam(':id', $input['id']);
  $stmt->bindParam(':cliente', $input['cliente']);
  $stmt->bindParam(':tipoPagamento', $input['tipoPagamento']);
  $stmt->bindParam(':valorIntegral', $input['valorIntegral']);
  $stmt->execute();

  echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
