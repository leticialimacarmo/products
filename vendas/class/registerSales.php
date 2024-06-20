<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $input = json_decode(file_get_contents('php://input'), true);

  $itens = $input['itens'];
  $parcelas = $input['parcelas'];

  foreach ($itens as $item) {
    $query = "INSERT INTO sales (produto, cliente, vendedor, quantidade, valorUnitario, valorIntegral, tipoPagamento) VALUES (:produto, :cliente, :vendedor, :quantidade, :valorUnitario, :subtotal, 'personalizado')";
    $stmt = $db->prepare($query);
    $stmt->execute([
      ':produto' => $item['produto'],
      ':cliente' => $item['cliente'],
      ':vendedor' => $item['vendedor'],
      ':quantidade' => $item['quantidade'],
      ':valorUnitario' => $item['valorUnitario'],
      ':subtotal' => $item['subtotal'],
    ]);
  }

  foreach ($parcelas as $parcela) {
    $query = "INSERT INTO payments (numero, valorParcela, dataVencimento) VALUES (:numero, :valorParcela, :dataVencimento)";
    $stmt = $db->prepare($query);
    $stmt->execute([
      ':numero' => $parcela['numero'],
      ':valorParcela' => $parcela['valorParcela'],
      ':dataVencimento' => $parcela['dataVencimento'],
    ]);
  }

  echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
