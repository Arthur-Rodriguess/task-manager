<?php

namespace TaskManager\Controllers;

use TaskManager\Controllers\Controller;
use TaskManager\Helpers\Status;
use TaskManager\Model\Repository\TaskRepository;

class TaskConcludeController extends AuthenticatedController
{
	public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$userId = $this->requireLogin();
		$this->taskRepository->expireTasks();

		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$task = $this->taskRepository->find($id, $userId);
		if ($task === null) {
			header("Location: /?success=0");
			exit();
		}

		$taskStatus = $task->getStatus();
		if ($taskStatus === Status::Expired) {
			header("Location: /?success=0");
			exit();
		}

		if ($taskStatus === Status::Concluded) {
			if($this->taskRepository->resetTask($id, $userId)) {
				header("Location: /?success=1");
				exit();
			}
			header("Location: /?success=0");
			exit();
		}

		if($this->taskRepository->conclude($task->id, $task->userId)) {
			header("Location: /?success=1");
		} else {
			header("Location: /?success=0");
		}
	}
}