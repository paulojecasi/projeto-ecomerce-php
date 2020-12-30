<?php
use \Hcode\Page;
use \Hcode\PageAdmin; 
use \Hcode\Model\User; 
use \Hcode\Model\Category;


// tela de categorias - mostra categorias cadastradas - pjcs
$app->get("/admin/categories", function()
{

	User::verifyLogin(); 

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTPL("categories", array (
			"categories"=>$categories 
	)); 


});

// vai para a tela de gravar categorias - pjcs
$app->get("/admin/categories/create", function()
{

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTPL("categories-create"); 


});

// grava categoria  - pjcs 
$app->post("/admin/categories/create", function()
{

	User::verifyLogin();

	$category = new Category(); 

	$category->setData($_POST);

	$category->save(); 

	header("Location: /admin/categories"); 
	exit; 

});


//deletar categoria
$app->get("/admin/categories/:idcategory/delete", function($idcategory)
{

	User::verifyLogin(); 

	$category= new Category();

	$category->get((int)$idcategory); 

	$category->delete(); 

	header("Location: /admin/categories"); 
	exit; 

});



// tela de update da categoria
$app->get("/admin/categories/:idcategory", function($idcategory)
{
	User::verifyLogin(); 
	
	$category= new Category(); 

	$category->get((int)$idcategory); 

	$page = new PageAdmin();

	$page->setTPL("categories-update", array(
			"category_up"=>$category->getData()
	)); 

});

// update da categoria 
$app->post("/admin/categories/:idcategory", function($idcategory)
{

	User::verifyLogin(); 

	$category = new Category();

	$category->get((int)$idcategory); 

	$category->setData($_POST);

	$category->update(); 

	header("Location: /admin/categories"); 
	exit; 


}); 

$app->get("/categories/:idcategory", function($idcategory)
{

	User::verifyLogin(); 

	$category = new Category();
	$category->get((int)$idcategory);

	$page = new Page();
	$page->setTPL("category",[
		'category'=>$category->getData(),
		'products'=>[]
	]);

});

?>
