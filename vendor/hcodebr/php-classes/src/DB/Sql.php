<?php 

namespace Hcode\DB;

// configuração de conexao com DB - daqui que vem as const DBNAME, HOSTNAME, USERNAME,
// e PASSWORD - PJCS 
require_once("connect.php");  

class Sql{

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=".DBNAME.";host=".HOSTNAME, 
			USERNAME, PASSWORD
		);

	}

	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array())
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

	}

	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}

}

$t = new Sql();
$t->host = "127.0.0.11111";

?>