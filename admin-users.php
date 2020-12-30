<?php

use \Hcode\PageAdmin; 
use \Hcode\Model\User; 

// --- listar todos os usuarios 
$app->get('/admin/users', function()
{
	User::verifyLogin(); 

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTPL("users", array(
		"users"=>$users
	)); 

}); 

// Tela de cadastro de usuario
$app->get('/admin/users/create', function()
{
	User::verifyLogin(); 
	
	$page = new PageAdmin();

	$page->setTPL("users-create"); 

}); 

//deletar usuario
$app->get("/admin/users/:iduser/delete", function($iduser)
{

	User::verifyLogin(); 

	$user= new User();

	$user->get((int)$iduser); 

	$user->delete(); 

	header("Location: /admin/users"); 
	exit; 

}); 

// tela de update do usuario 
$app->get('/admin/users/:iduser', function($iduser)
{
	User::verifyLogin(); 
	
	$user= new User(); 

	$user->get((int)$iduser); 

	$page = new PageAdmin();

	$page->setTPL("users-update", array(
			"user"=>$user->getData()
	)); 

}); 

// Grava usuario (POST)
$app->post("/admin/users/create", function()
{

	User::verifyLogin(); 

	$user = new User();

	// se $_POST["inadmin"] for definido, o valor = 1, se não =0
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0; 

	$user->setData($_POST); 

	$user->save(); 

	header("Location: /admin/users"); 
	exit; 

}); 

$app->post("/admin/users/:iduser", function($iduser)
{

	User::verifyLogin(); 

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0; 

	$user->get((int)$iduser); 

	$user->setData($_POST); 

	$user->update(); 

	header("Location: /admin/users"); 
	exit; 


}); 

?>