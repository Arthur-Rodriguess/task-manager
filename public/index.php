<?php
require_once __DIR__ . "/../vendor/autoload.php";

use TaskManager\Controllers\Controller;
use TaskManager\Controllers\Error404Controller;
use TaskManager\Controllers\TaskAddController;
use TaskManager\Controllers\TaskEditController;
use TaskManager\Controllers\TaskFormController;
use TaskManager\Controllers\TaskListController;
use TaskManager\Controllers\TaskRemoveController;
use TaskManager\Model\Repository\TaskRepository;
date_default_timezone_set('America/Fortaleza');
$dbPath = __DIR__ . "/../database.sqlite";
$pdo = new PDO("sqlite:$dbPath");
$taskRepository = new TaskRepository($pdo);

$routes = require_once __DIR__ . "/../config/routes.php";

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];
$key = "$httpMethod|$pathInfo";

if(array_key_exists($key, $routes)) {
	$controllerClass = $routes[$key];
	$controller = new $controllerClass($taskRepository);
} else {
	$controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->processaRequisicao();