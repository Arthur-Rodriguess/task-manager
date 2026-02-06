<?php

namespace TaskManager\Controllers;

use TaskManager\Controllers\Controller;
use TaskManager\Helpers\Status;
use TaskManager\Model\Repository\TaskRepository;

class TaskConcludeController implements Controller
{
	public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$task = $this->taskRepository->find($id);
		if ($task === null) {
			header("Location: /?success=0");
			exit();
		}

		$taskStatus = $task->getStatus();
		if ($taskStatus === Status::Concluded || $taskStatus === Status::Expired) {
			header("Location: /?success=0");
			exit();
		}

		if($this->taskRepository->conclude($task->id)) {
			header("Location: /?success=1");
		} else {
			header("Location: /?success=0");
		}
	}
}