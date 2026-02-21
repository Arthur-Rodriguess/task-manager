<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\TaskRepository;

class TaskRemoveController extends AuthenticatedController
{
	public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$userId = $this->requireLogin();
		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

		if ($this->taskRepository->find($id, $userId) === null) {
			header("Location: /?success=0");
			exit();
		}

		if ($this->taskRepository->remove($id, $userId)) {
			header("Location: /?success=1");
		} else {
			header("Location: /?success=0");
		}
	}
}