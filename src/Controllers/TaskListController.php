<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\TaskRepository;

class TaskListController extends AuthenticatedController
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function processaRequisicao(): void
    {
		$userId = $this->requireLogin();

		$this->taskRepository->expireTasks();
		$taskList = $this->taskRepository->all($userId);
		foreach ($taskList as $task) {
			$task->recalculateStatus();
		}
		require_once __DIR__ . "/../../views/home.php";

	}
}