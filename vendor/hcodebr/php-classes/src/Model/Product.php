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

			$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)",	array(
					":idproduct"	=>$this->getidproduct(), 
					":desproduct"	=>$this->getdesproduct(),
					":vlprice"		=>$this->getvlprice(),
					":vlwidth"		=>$this->getvlwidth(),
					":vlheight"		=>$this->getvlheight(),
					":vllength"		=>$this->getvllength(),
					":vlweight"		=>$this->getvlweight(),
					":desurl"			=>$this->getdesurl()
			));

			print_r($results[0]);
			exit; 
			//$this->setData($results[0]);

		}

		public function get($idproduct)
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :id_product", array(
					":id_product"=>$idproduct
			));

			$this->setData($results[0]); 

		}


}