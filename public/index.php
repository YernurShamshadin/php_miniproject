<?php

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shamshadinye\MyPhpProject\Http\Controllers;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', Controllers\IndexController::class . ':home');
$app->get('/adverts', Controllers\AdvertController::class . ':index');
$app->get('/adverts/new', Controllers\AdvertController::class . ':newAdvert');
$app->post('/adverts', Controllers\AdvertController::class . ':create');
$app->get('/adverts/{id}', Controllers\AdvertController::class . ':show');
$app->post('/adverts/{id}/edit', Controllers\AdvertController::class . ':update');
$app->get('/adverts/{id}/edit', Controllers\AdvertController::class . ':edit');


$app->run();
