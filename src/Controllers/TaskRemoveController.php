<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\TaskRepository;

class TaskRemoveController implements Controller
{
	public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

		if ($this->taskRepository->find($id) === null) {
			header("Location: /?success=0");
			exit();
		}

		if ($this->taskRepository->remove($id)) {
			header("Location: /?success=1");
		} else {
			header("Location: /?success=0");
		}
	}
}