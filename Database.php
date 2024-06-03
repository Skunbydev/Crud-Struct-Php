<?php
//Abstração DO CRUD
//CRUD abstraction

include 'db_config.php';

class Database
{
  private $connection;

  public function __construct()
  {
    //verifica se a conexão está correta
    //verify connection
    $this->connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (!$this->connection) {
      die('Connection failed: ' . mysqli_connect_error());
    }
  }

  // Método para executar uma consulta SQL e retornar o resultado
// Method to execute a SQL query and return the result
  public function query($sql)
  {
    // Executa a consulta utilizando a conexão estabelecida
    // Execute the query using the established connection
    $result = mysqli_query($this->connection, $sql);

    // Verifica se houve algum erro na consulta
    // Check if there was any error in the query
    if (!$result) {
      // Em caso de erro, interrompe a execução do script e exibe a mensagem de erro
      // In case of error, stop the script execution and display the error message
      die('Query failed: ' . mysqli_error($this->connection));
    }

    // Retorna o resultado da consulta
    // Return the query result
    return $result;
  }

  // Método para recuperar todas as linhas de um resultado de consulta e retorná-las como um array associativo
// Method to retrieve all rows from a query result and return them as an associative array
  public function fetchAll($result)
  {
    // Retorna todas as linhas do resultado como um array associativo
    // Return all rows from the result as an associative array
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }

  // Método para recuperar uma única linha de um resultado de consulta e retorná-la como um array associativo
// Method to retrieve a single row from a query result and return it as an associative array
  public function fetchRow($result)
  {
    // Retorna uma única linha do resultado como um array associativo
    // Return a single row from the result as an associative array
    return mysqli_fetch_assoc($result);
  }

  // Método para escapar uma string para uso seguro em consultas SQL
// Method to escape a string for safe use in SQL queries
  public function escapeString($string)
  {
    // Escapa a string utilizando a conexão estabelecida
    // Escape the string using the established connection
    return mysqli_real_escape_string($this->connection, $string);
  }

  // Método para inserir dados em uma tabela do banco de dados
// Method to insert data into a database table
  public function insert($table, $data)
  {
    // Obtém os nomes das colunas e os valores dos dados a serem inseridos
    // Get the column names and values of the data to be inserted
    $columns = implode(", ", array_keys($data));
    $values = implode("', '", array_map([$this, 'escapeString'], array_values($data)));

    // Constrói e executa a consulta SQL de inserção
    // Build and execute the SQL insertion query
    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
    return $this->query($sql);
  }

  // Método para atualizar dados em uma tabela do banco de dados
// Method to update data in a database table
  public function update($table, $data, $where)
  {
    // Constrói a cláusula SET da consulta SQL de atualização
    // Build the SET clause of the SQL update query
    $set = [];
    foreach ($data as $column => $value) {
      $set[] = "$column = '" . $this->escapeString($value) . "'";
    }
    $set = implode(", ", $set);

    // Constrói e executa a consulta SQL de atualização
    // Build and execute the SQL update query
    $sql = "UPDATE $table SET $set WHERE $where";
    return $this->query($sql);
  }

  // Método para excluir dados de uma tabela do banco de dados
// Method to delete data from a database table
  public function delete($table, $where)
  {
    // Constrói e executa a consulta SQL de exclusão
    // Build and execute the SQL delete query
    $sql = "DELETE FROM $table WHERE $where";
    return $this->query($sql);
  }

  // Método para fechar a conexão com o banco de dados
// Method to close the connection to the database
  public function close()
  {
    // Fecha a conexão com o banco de dados
    // Close the connection to the database
    mysqli_close($this->connection);
  }

}
?>