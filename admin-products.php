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

	$page->setTPL("products-create"); 

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

?> 