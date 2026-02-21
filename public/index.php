<?php
require_once __DIR__ . "/../vendor/autoload.php";

use TaskManager\Controllers\Controller;
use TaskManager\Controllers\Error404Controller;
use TaskManager\Controllers\TaskAddController;
use TaskManager\Controllers\TaskEditController;
use TaskManager\Controllers\TaskFormController;
use TaskManager\Controllers\TaskListController;
use TaskManager\Controllers\TaskRemoveController;
use TaskManager\Middleware\AuthMiddleware;
use TaskManager\Model\Repository\TaskRepository;
use TaskManager\Model\Repository\UserRepository;

date_default_timezone_set('America/Fortaleza');
$dbPath = __DIR__ . "/../database.sqlite";
$pdo = new PDO("sqlite:$dbPath");
$taskRepository = new TaskRepository($pdo);
$userRepository = new UserRepository($pdo);

session_start();
session_regenerate_id();

$routes = require_once __DIR__ . "/../config/routes.php";

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];
$key = "$httpMethod|$pathInfo";

if(array_key_exists($key, $routes)) {
	$route = $routes[$key];

	if($route['auth'] === true) {
		AuthMiddleware::handle();
	}

	$controllerClass = $route['controller'];
	$reflection = new ReflectionClass($controllerClass);
	$constructor = $reflection->getConstructor();

	if($constructor) {
		$params = $constructor->getParameters();
		if(count($params) > 0) {
			$dependency = $params[0];
			$dependencyType = $dependency->getType()->getName();

			$controller = match ($dependencyType) {
				TaskRepository::class => new $controllerClass($taskRepository),
				UserRepository::class => new $controllerClass($userRepository)
			};
		} else {
			$controller = new $controllerClass();
		}
	}
} else {
	$controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->processaRequisicao();