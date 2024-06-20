<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = "SELECT * FROM products WHERE data_deleted IS NULL ORDER BY id DESC";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $items = array_map(function ($item) {
    return [
      'id' => $item['id'],
      'codigo' => $item['codigo'],
      'descricao' => $item['descricao'],
      'valor' => $item['valor'],
      'fornecedor' => $item['fornecedor'],
      'data_cadastro' => $item['data_cadastro']
    ];
  }, $res);

  echo json_encode(['data' => $items]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
