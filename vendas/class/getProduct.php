<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = "SELECT * FROM products WHERE data_deleted IS NULL";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $items = array_map(function ($item) {
    return [
      'id' => $item['id'],
      'codigo' => $item['codigo'],
      'descricao' => $item['descricao'],
    ];
  }, $res);

  echo json_encode(['data' => $items]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
