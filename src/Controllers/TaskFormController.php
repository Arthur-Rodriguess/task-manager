<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\TaskRepository;

class TaskFormController extends AuthenticatedController
{
    public function __construct(private TaskRepository $taskRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$user_id = $this->requireLogin();

		$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
		$task = null;
		if($id !== null && $id !== false) {
			$task = $this->taskRepository->find($id, $user_id);
		}

		require_once __DIR__ . "/../../views/task-form.php";
	}
}