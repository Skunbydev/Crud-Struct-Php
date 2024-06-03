<?php
include 'Database.php';

$db = new Database();

// Exemplo de consulta
$result = $db->query("SELECT * FROM clients");

// Fetch all results
$rows = $db->fetchAll($result);
foreach ($rows as $row) {
  echo "ID: " . $row['id_cliente'] . " - Nome: " . $row['nome_cliente'] . "<br>";
}

// Exemplo de inserção
$data = [
  'nome_cliente' => 'Luis Filipe',
];
$db->insert('clients', $data);

// Exemplo de atualização
$data = [
  'nome_cliente' => 'Luiz Felipe',
];
$db->update('clients', $data, "id_cliente = 2");

// Exemplo de exclusão
$db->delete('clients', "id_cliente = 3");

//Exemplo simples de IF.
$result = $db->query("SELECT * FROM clients");
$results = $db->fetchAll($result);

// Verifica se o número de registros é maior que 10
if (count($results) > 10) {
  echo 'Ultrapassou 10 registros!';
  // Deleta todos os registros da tabela 'clients'
  $db->query("DELETE FROM clients");
}

// Fechar a conexão
$db->close();
?>