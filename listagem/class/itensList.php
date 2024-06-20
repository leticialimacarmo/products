<?php

require_once '../../common/db.php';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = "SELECT DISTINCT id_venda, tipoPagamento, data_cadastro FROM sales WHERE data_deleted IS NULL ORDER BY id DESC";

  $stmt = $db->prepare($query);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $data = array_map(function ($item) {
    return [
      'id' => $item['id_venda'],
      'tipoPagamento' => $item['tipoPagamento'],
      'data_cadastro' => $item['data_cadastro']
    ];
  }, $res);

  echo json_encode(['data' => $data]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
