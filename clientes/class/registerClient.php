<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $data = json_decode(file_get_contents("php://input"), true);


  $requiredFields = ['nomeFantasia', 'razaoSocial', 'cpf', 'cidade'];
  foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
      throw new Exception('Todos os campos são obrigatórios.');
    }
  }

  $query = "INSERT INTO clients (nomeFantasia, razaoSocial, cpf, cidade, data_cadastro)
              VALUES (:nomeFantasia, :razaoSocial, :cpf, :cidade, NOW())";
  $stmt = $db->prepare($query);


  $stmt->bindParam(':nomeFantasia', $data['nomeFantasia']);
  $stmt->bindParam(':razaoSocial', $data['razaoSocial']);
  $stmt->bindParam(':cpf', $data['cpf']);
  $stmt->bindParam(':cidade', $data['cidade']);
  $stmt->execute();


  echo json_encode(['success' => true]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Erro ao tentar cadastrar o cliente: ' . $e->getMessage()]);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
