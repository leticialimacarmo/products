<?php

require_once '../../common/db.php';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $query = "SELECT id, cliente, tipoPagamento, valorIntegral FROM sales WHERE id_venda = :id";

  $stmt = $db->prepare($query);
  $stmt->bindParam(':id', $input['id']);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $data = array_map(function ($item) {
    return [
      'id' => $item['id'],
      'cliente' => $item['cliente'],
      'tipoPagamento' => $item['tipoPagamento'],
      'valorIntegral' => $item['valorIntegral']
    ];
  }, $res);

  echo json_encode(['data' => $data]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
