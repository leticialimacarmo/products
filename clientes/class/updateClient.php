<?php
$dsn = 'mysql:host=localhost;dbname=testeDC';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = json_decode(file_get_contents("php://input"), true);

  $requiredFields = ['id', 'nomeFantasia', 'razaoSocial', 'cpf', 'cidade'];
  foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
      throw new Exception('Todos os campos são obrigatórios.');
    }
  }

  $query = "UPDATE clients 
              SET nomeFantasia = :nomeFantasia, razaoSocial = :razaoSocial, 
                  cpf = :cpf, cidade = :cidade
              WHERE id = :id";
  $stmt = $db->prepare($query);

  $stmt->bindParam(':id', $data['id']);
  $stmt->bindParam(':nomeFantasia', $data['nomeFantasia']);
  $stmt->bindParam(':razaoSocial', $data['razaoSocial']);
  $stmt->bindParam(':cpf', $data['cpf']);
  $stmt->bindParam(':cidade', $data['cidade']);
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
