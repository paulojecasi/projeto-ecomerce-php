<?php 

namespace Hcode\DB;

// configuração de conexao com DB - daqui que vem as const DBNAME, HOSTNAME, USERNAME,
// e PASSWORD - PJCS 


/* PDO  

// conectar com o banco via PDO =  PHP DATA OBJECT 
$con = new PDO("mysql:dbname=alunos;host=localhost", "paulocardoso", "lr1404");

// passar os dados (VALUES) via parametros, para mais segurança(:NOME, :CURSO ect)
$stmt = $con->prepare("INSERT INTO alunos_curso(nome, curso, matricula, status, turno) VALUES(:NOME, :CURSO, :MATRICULA, :STATUS, :TURNO)");

// dados para o insert
$nome = "Jesse Jecao";
$curso = "Roça";
$matricula = "0002";
$status = "Nunca Terminuo";
$turno= "Dia todo"; 

$stmt->bindParam(":NOME",  $nome);
$stmt->bindParam(":CURSO", $curso);
$stmt->bindParam(":MATRICULA", $matricula);
$stmt->bindParam(":STATUS", $status);
$stmt->bindParam(":TURNO", $turno);

$stmt->execute(); 

require_once("select_pdo.php")

*/

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

?>