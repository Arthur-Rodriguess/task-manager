<?php

namespace TaskManager\Model\Repository;

use PDO;
use TaskManager\Helpers\Status;
use TaskManager\Model\Entity\Task;

class TaskRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(Task $task): bool
    {
        $sql = "INSERT INTO tasks (title, description, task_date, user_id, status) VALUES (:title, :description, :task_date, :user_id, :status)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":title", $task->title);
        $statement->bindValue(":description", $task->description);
        $statement->bindValue(":task_date", $task->date);
		$statement->bindValue(":user_id", $task->userId, PDO::PARAM_INT);
		$statement->bindValue(":status", $task->getStatus()->value);
        return $statement->execute();
    }

    public function edit(Task $task): bool
    {
        $sql = "UPDATE tasks SET title = :title, description = :description, task_date = :task_date, status = :status WHERE id = :id AND user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute([
            ":title" => $task->title,
            ":description" => $task->description,
            ":task_date" => $task->date,
            ":status" => $task->getStatus()->value,
            ":id" => $task->id,
			":user_id" => $task->userId
        ]);
    }

    /**
     * @return Task[]
     */
    public function all(int $userId): array
    {
        $sql = "SELECT * FROM tasks WHERE user_id = ?";
        $statement = $this->pdo->prepare($sql);
		$statement->bindValue(1, $userId, PDO::PARAM_INT);
		$statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

		$tasks = [];

		foreach ($data as $row) {
			$status = Status::tryFrom($row['status']) ?? Status::Pending;

			$task = new Task(
				$row['title'],
				$row['description'],
				$row['task_date'],
				$row['user_id'],
				$status
			);

			$task->setId($row['id']);
			$tasks[] = $task;
		}

		return $tasks;
	}

    /**
     * @return null|Task
     */
    public function find(int $id, int $userId): ?Task
    {
        $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->bindValue(2, $userId, PDO::PARAM_INT);
        if($statement->execute() === false) {
            return null;
        }
		$row = $statement->fetch(PDO::FETCH_ASSOC);

		if (!$row) {
			return null;
		}

		$status = Status::tryFrom($row['status']) ?? Status::Pending;

		$task = new Task(
			$row['title'],
			$row['description'],
			$row['task_date'],
			$row['user_id'],
			$status
		);

		$task->setId($row['id']);

		return $task;
	}

    public function remove(int $id, int $userId): bool
    {
        $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->bindValue(2, $userId, PDO::PARAM_INT);
        return $statement->execute();
    }

	public function conclude(int $id, int $userId): bool
	{
		$sql = "UPDATE tasks SET status = :concluded WHERE id = :id AND user_id = :user_id";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(":concluded", Status::Concluded->value);
		$statement->bindValue(":id", $id, PDO::PARAM_INT);
		$statement->bindValue(":user_id", $userId, PDO::PARAM_INT);
		return $statement->execute();
	}

	/**
	 * @param array $data
	 * @return Task[]
	 */
	private function hydrateList(array $data): array
	{
		$tasks = [];
		foreach($data as $row) {
			$status = Status::tryFrom($row['status']) ?? Status::Pending;
			$task = new Task(
				$row['title'],
				$row['description'],
				$row['task_date'],
				$row['user_id'],
				$status
			);
			$task->setId($row['id']);
			$tasks[] = $task;
		}
		return $tasks;
	}

	public function expireTasks(): void
	{
		$sql = "UPDATE tasks SET status = :expired WHERE task_date < datetime('now', 'localtime') and status = :pending";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(":expired", Status::Expired->value);
		$statement->bindValue(":pending", Status::Pending->value);
		$statement->execute();
	}

	public function resetTask(int $id, int $userId): bool
	{
		$sql = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
		$statement = $this->pdo->prepare($sql);
		return $statement->execute([
			Status::Pending->value,
			$id,
			$userId
		]);
	}
}