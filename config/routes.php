<?php

use TaskManager\Controllers\{
	TaskAddController,
	TaskConcludeController,
	TaskEditController,
	TaskFormController,
	TaskListController,
	TaskRemoveController
};

return [
	"GET|/" => TaskListController::class,
	"GET|/new-task" => TaskFormController::class,
	"POST|/new-task" => TaskAddController::class,
	"GET|/edit-task" => TaskFormController::class,
	"POST|/edit-task" => TaskEditController::class,
	"GET|/remove-task" => TaskRemoveController::class,
	"GET|/conclude-task" => TaskConcludeController::class
];