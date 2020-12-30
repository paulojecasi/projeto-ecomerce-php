<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model;

class Category extends Model{

	
		public static function listAll()
		{

			$sql = new Sql(); 

			return $sql->select("SELECT * FROM tb_categories ORDER BY descategory"); 

		}


		public function save()
		{
			$sql = new Sql();

			/* sequencia da PROCEDURE SP_CATEGORIES_SAVE
			pdescategoty VARCHAR(64)
			*/

			$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)",
				array(
					":idcategory"=>$this->getidcategory(), 
					":descategory"=>$this->getdescategory()

			));

			$this->setData($results[0]); 
			Category::updateCaregory(); 

		}

		public function get($idcategory)
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :id_category", array(
					":id_category"=>$idcategory
			));

			$this->setData($results[0]); 

		}


		public function update()
		{
			$sql = new Sql();

			$sql->select("UPDATE tb_categories SET descategory = :descategory WHERE idcategory = :idcategory",
				array(
					":idcategory"=>$this->getidcategory(), 
					":descategory"=>$this->getdescategory()
			));

		}

		public function delete()
		{
			$sql = new Sql();

			$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",[
					':idcategory'=>$this->getidcategory(), 
			]);

			Category::updateCaregory(); 
		}

		// carrega as categorias 
		public static function updateCaregory()
		{

			$categories = Category::listAll();

			$html = []; 

			foreach ($categories as $row){
				array_push($html,'<li> <a href="/categories/'.$row['idcategory'].'"> '.$row['descategory'].' </a> </li>');
			}

			// $_SERVER['DOCUMENT_ROOT'] = caminho do arquivo
			// DIRECTORY_SEPARATOR = separador de diretorio (substitui o / ou \)
			// OBS: explode= string para array, implode= array para string

			// aqui vamos adicionar os dados do array $html no arquivo "categories-menu.html"
			file_put_contents($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . "views" .
			 DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html)); 

		}

}