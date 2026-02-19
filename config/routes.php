<?php

use TaskManager\Controllers\{LoginController,
	LoginFormController,
	LogoutController,
	RegisterController,
	RegisterFormController,
	TaskAddController,
	TaskConcludeController,
	TaskEditController,
	TaskFormController,
	TaskListController,
	TaskRemoveController};

return [
	"GET|/" => [
		'controller' => TaskListController::class,
		'auth' => true
	],
	"GET|/new-task" => [
		'controller' => TaskFormController::class,
		'auth' => true
	],
	"POST|/new-task" => [
		'controller' => TaskAddController::class,
		'auth' => true
	],
	"GET|/edit-task" => [
		'controller' => TaskFormController::class,
		'auth' => true
	],
	"POST|/edit-task" => [
		'controller' => TaskEditController::class,
		'auth' => true
	],
	"GET|/remove-task" => [
		'controller' => TaskRemoveController::class,
		'auth' => true
	],
	"GET|/conclude-task" => [
		'controller' => TaskConcludeController::class,
		'auth' => true
	],
	"GET|/login" => [
		'controller' => LoginFormController::class,
		'auth' => false
	],
	"POST|/login" => [
		'controller' => LoginController::class,
		'auth' => false
	],
	"GET|/register" => [
		'controller' => RegisterFormController::class,
		'auth' => false
	],
	"POST|/register" => [
		'controller' => RegisterController::class,
	],
	"GET|/logout" => [
		'controller' => LogoutController::class,
		'auth' => true
	]
];