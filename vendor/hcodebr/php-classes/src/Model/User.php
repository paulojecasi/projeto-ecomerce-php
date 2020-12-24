<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model;

class User extends Model{

		const SESSION= "User";

		public static function login($login, $password){

				$sql = new Sql();

				$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
						":LOGIN"=>$login
				));

				if (count($results) === 0)
				{

						throw new \Exception("USUARIO Inexistente ou senha invalida.");
						
				}

				$data = $results[0]; 

				if (password_verify($password, $data["despassword"]) === true)
				{

						$user = new User(); 

						// aqui poderei utilizar qualquer nome para o metodo, pois sera chamado o 
						// metodo magico "__call" na classe Model que reconhecera o metodo utilizado 
						// por mim, mas como queremos identificar o GET e SET, vamos descrever o 3
						// primeiros caracteres como "get" ou "set".

						//$user-> setiduser($data["iduser"]);  
						$user->setData($data); 
						var_dump($user); 

						$_SESSION[User::SESSION] = $user->getData(); 

						return $user; 

				} else {
						var_dump($results);
						var_dump($password);
						var_dump($data["despassword"]);

						throw new \Exception("Usuario Inexistente ou SENHA invalida.");

				}
	

		}

		public static function verifyLogin($inadmin = true)
		{

				if ( 	
						!isset($_SESSION[User::SESSION]) 							// se nao for definida
							|| 
						!$_SESSION[User::SESSION]											// se for falsa
							||
						!(int)$_SESSION[User::SESSION]["iduser"] > 0		// se o ID nao nao for > 0
							||
						(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin // se é usuario ADM 
						)
				{

						header("Location: /admin/login");
						exit; 

				}

		}

		public static function logout()
		{
				$SESSION[User::SESSION] = NULL; 
		}

		public static function listAll()
		{

				$sql = new Sql(); 

				return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson"); 

		}

}