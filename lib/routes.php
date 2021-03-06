<?php

//$app = new Silex\Application();

$app->get('/list', 'App\\ProductController::listAction');
$app->get('/list/tax', 'App\\ProductController::listTaxAction');
$app->get('/tax/info/{id}', 'App\\ProductController::taxInfoAction')->assert('id', '\w+');
$app->get('/form', 'App\\ProductController::formAction');
$app->get('/add', 'App\\ProductController::addAction');
$app->post('/add', 'App\\ProductController::saveAction')->bind('product_add');
$app->get('/info/{id}', 'App\\ProductController::infoAction')->assert('id', '\w+');
$app->get('/edit/{id}', 'App\\ProductController::addAction')->assert('id', '\w+');
$app->put('/edit/{id}', 'App\\ProductController::saveAction')->assert('id', '\w+');
$app->delete('/del/{id}', 'App\\ProductController::deleteAction')->assert('id', '\w+');
