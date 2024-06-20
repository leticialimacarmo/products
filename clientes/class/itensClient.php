<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';


try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $query = "SELECT * FROM clients WHERE data_deleted IS NULL ORDER BY id DESC";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $res = $stmt->fetchAll(PDO::FETCH_ASSOC);


  $itens = array_map(function ($item) {
    return  [
      'id' => $item['id'],
      'nomeFantasia' => $item['nomeFantasia'],
      'razaoSocial' => $item['razaoSocial'],
      'cpf' => $item['cpf'],
      'cidade' => $item['cidade'],
      'data_cadastro' => $item['data_cadastro']
    ];
  }, $res);


  echo json_encode(['data' =>$itens]);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
