<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\TaskRepository;

class TaskListController implements Controller
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function processaRequisicao(): void
    {
		$this->taskRepository->expireTasks();
		$taskList = $this->taskRepository->all();
		foreach ($taskList as $task) {
			$task->recalculateStatus();
		}
		require_once __DIR__ . "/../../views/home.php";

	}
}