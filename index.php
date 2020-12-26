<?php 
session_start();
require_once("vendor/autoload.php");
use \Slim\Slim;
use \Hcode\Page; 
use \Hcode\PageAdmin; 
use \Hcode\Model\User; 

$app = new Slim();

$app->config('debug', true);

$app->get('/', function()
{
    $page = new Page(); 
    $page->setTPL("index");
});

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

}); 


$app->run();

?>