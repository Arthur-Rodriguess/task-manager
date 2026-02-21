<?php

namespace TaskManager\Controllers;

use TaskManager\Helpers\Status;
use TaskManager\Model\Entity\Task;
use TaskManager\Model\Repository\TaskRepository;

class TaskEditController extends AuthenticatedController
{
	public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$user_id = $this->requireLogin();

		$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
		$date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);

		if ($id === null || $id === false || !$title || !$description || !$date) {
			header("Location: /?success=0");
			exit();
		}

		$task = new Task($title, $description, $date, $user_id, Status::Pending);

		$task->setId($id);

		$task->recalculateStatus();

		if ($this->taskRepository->edit($task)) {
			header("Location: /?success=1");
		} else {
			header("Location: /?success=0");
		}
	}
}