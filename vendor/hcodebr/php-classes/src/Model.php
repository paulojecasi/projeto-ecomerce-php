<?php

namespace Hcode; 

class Model {

	private $values = [];

	public function __call($name, $args)
	{

			$method = substr($name, 0,3);       					// da posição 0, 3 caracteres)
			$fieldName = substr($name, 3, strlen($name));	// da posicao 3, demais caracteres)  

			//var_dump($method, $fieldName); 
			//exit;

			switch ($method) {
				case "get":

					return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
					break;

				case "set": 

					$this->values[$fieldName] = $args[0]; 
					break;
			}

	}

	public function setData($data = array() ) {

		foreach ($data as $key => $value) {
				// vamos criar o nome do SET concatenando a string "set" com os campos(key) 
				// e valores($value)
				// objetos STATICOS são definidos com {}

				$this->{"set".$key}($value); 

		}


	}

	public function getData()
	{
		return $this->values; 
	}

}



?>