<?php

use \Hcode\PageAdmin; 
use \Hcode\Model\User; 
use \Hcode\Model\Product;

// tela principal de produtos - mostra produtos cadastrados - pjcs
$app->get("/admin/products", function()
{

	User::verifyLogin(); 

	$products = Product::listAll();

	$page = new PageAdmin();

	$page->setTPL("products", array (
			"products"=>$products
	)); 

});

// tela de cadastro de produtos 
$app->get("/admin/products/create", function()
{

	User::verifyLogin(); 

	$page = new PageAdmin();

	$control = Product::controlSelect(); 

	$page->setTPL("products-create", array(
		"control_select" => $control
	)); 

});

// cadastra produtos 
$app->post("/admin/products/create", function()
{

	User::verifyLogin(); 

	$product = new Product(); 

	$product->setData($_POST); 

	$product->save(); 

	header("Location: /admin/products");
	exit; 

});


//deletar produtos
$app->get("/admin/products/:idproduct/delete", function($idproduct)
{

	User::verifyLogin(); 

	$product= new Product();

	$product->get((int)$idproduct); 

	$product->delete(); 

	header("Location: /admin/products"); 
	exit; 

});



// tela de update do produto
$app->get("/admin/products/:idproduct", function($idproduct)
{
	User::verifyLogin(); 
	
	$product= new Product(); 

	$control= $product::controlSelect(); 

	$product->get((int)$idproduct); 

	$page = new PageAdmin();

	$page->setTPL("products-update", array(
			"product_up"=>$product->getData(), 
			"control_select"=>$control
	)); 

});

// update do produto
$app->post("/admin/products/:idcategory", function($idproduct)
{

	User::verifyLogin(); 

	$product = new Product();

	$product->get((int)$idproduct); 

	$product->setData($_POST);

	$product->update(); 

	header("Location: /admin/products"); 
	exit; 


}); 

?> 