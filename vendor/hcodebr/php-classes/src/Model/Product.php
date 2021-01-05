<?php

namespace Hcode\Model;

use \Hcode\DB\Sql; 
use \Hcode\Model;

class Product extends Model{

	
		public static function listAll()
		{

			$sql = new Sql(); 

			return $sql->select("SELECT * FROM tb_products ORDER BY desproduct"); 

		}


		public function save()
		{

			$sql = new Sql();

			/* sequencia da PROCEDURE SP_PRODUCTS_SAVE
			pidproduct int(11),
			pdesproduct varchar(64),
			pvlprice decimal(10,2),
			pvlwidth decimal(10,2),
			pvlheight decimal(10,2),
			pvllength decimal(10,2),
			pvlweight decimal(10,2),
			pdesurl varchar(128)
			*/

			
			$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl, :actproduct)",
				array(
					":idproduct"=>$this->getidproduct(), 
					":desproduct"=>$this->getdesproduct(),
					":vlprice"=>$this->getvlprice(),
					":vlwidth"=>$this->getvlwidth(),
					":vlheight"=>$this->getvlheight(),
					":vllength"=>$this->getvllength(),
					":vlweight"=>$this->getvlweight(),
					":desurl"=>$this->getdesurl(),
					":actproduct"=>$this->getactproduct()
			));

			$this->setData($results[0]);

		}

		public function get($idproduct)
		{
			$sql = new Sql();


			$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :id_product", array(
					":id_product"=>$idproduct
			));

			$this->setData($results[0]); 

		}

		public function update()
		{
			$sql = new Sql();

			$sql->select("UPDATE tb_products 
				SET 
					desproduct 	= :desproduct,
					vlprice    	= :vlprice,
					vlwidth			=	:vlwidth,
					vlheight		=	:vlheight,
					vllength		= :vllength,
					vlweight 		=	:vlweight,
					desurl			=	:desurl,
					actproduct  = :actproduct
				WHERE
				 	idproduct 	= :idproduct",
				array(
					":idproduct"=>$this->getidproduct(), 
					":desproduct"=>$this->getdesproduct(),
					":vlprice"=>$this->getvlprice(),
					":vlwidth"=>$this->getvlwidth(),
					":vlheight"=>$this->getvlheight(),
					":vllength"=>$this->getvllength(),
					":vlweight"=>$this->getvlweight(),
					":desurl"=>$this->getdesurl(),
					":actproduct"=>$this->getactproduct()
			));

		}

		public function delete()
		{
			$sql = new Sql();

			$sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct",[
					':idproduct'=>$this->getidproduct(), 
			]);

		}

		public function checkPhoto()
		{
			// o nome da foto é o mesmo id do produto
			if (file_exists(
					$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
					"res" . DIRECTORY_SEPARATOR .
					"site" . DIRECTORY_SEPARATOR .
					"img" . DIRECTORY_SEPARATOR .
					"products" . DIRECTORY_SEPARATOR .
					$this->getidproduct() . ".jpg"
			)){

					$url = "/res/site/img/products/" . $this->getidproduct() . ".jpg";

			} else {

					$url = "/res/site/img/product.jpg"; 

			}

			return $this->setdesphoto($url);

		}

		public function getData()
		{

			$this->checkPhoto(); 

			$values = parent::getData();

			return $values; 

		}

		public function setPhoto($file)
		{
					// explode - aqui, criara um array apartir do local onde 
					// tiver (.) ponto, para pegar a extensão do arquivo
			$extension = explode('.', $file['name']); // fez um array apartir do ponto (.)
			$extension = end($extension);  // a ultima posição que ele achou do array

			switch ($extension) {
				case 'jpg':
				case 'jpeg':
					$image = imagecreatefromjpeg($file['tmp_name']); 
				break;

				case 'gif':
					$image = imagecreatefromgif($file['tmp_name']);
				break;

				case 'png':
					$image = imagecreatefrompng($file['tmp_name']);
				break;

			}

			$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
					"res" . DIRECTORY_SEPARATOR .
					"site" . DIRECTORY_SEPARATOR .
					"img" . DIRECTORY_SEPARATOR .
					"products" . DIRECTORY_SEPARATOR .
					$this->getidproduct() . ".jpg";

			imagejpeg($image, $dist); 
			imagedestroy($image);
			 
			$this->checkPhoto();

		}

		public static function controlSelect()
		{
			return $control_select = array(
					"yes"=>"S",
					"no" =>"N"); 
		}

}