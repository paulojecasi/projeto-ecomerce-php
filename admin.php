<?php

use \Hcode\PageAdmin; 
use \Hcode\Model\User; 

$app->get('/admin', function()
{
	User::verifyLogin(); 

  $page = new PageAdmin(); 
  $page->setTPL("index");
});

$app->get('/admin/login', function()
{
  $page = new PageAdmin([
  	"header"=>false,
  	"footer"=>false
  ]);

  $page->setTPL("login");
});


$app->post('/admin/login', function()
{

	User::login($_POST["login"],$_POST["password"]); 

	header("Location: /admin");  // redirecionamento da pagina 
	exit; 

});

$app->get('/admin/logout', function()
{
	User::logout();

	header("Location: /admin/login"); 
	exit; 

});

?>