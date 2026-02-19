<?php

namespace TaskManager\Model\Repository;

use PDO;
use TaskManager\Model\Entity\User;

class UserRepository
{
	public function __construct(private PDO $pdo)
	{
	}

	private function hydrateUser(array $userData): User
	{
		$user = new User(
			$userData['username'],
			$userData['email'],
			$userData['password']
		);
		$user->setId($userData['id']);

		return $user;
	}

	public function add(User $user): bool
	{
		$sql = "INSERT INTO users (username, email, password) values (?, ?, ?)";
		$statement = $this->pdo->prepare($sql);

		return $statement->execute([
			$user->username,
			$user->email,
			$user->hash
		]);
	}

	public function edit(User $user): bool
	{
		$sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
		$statement = $this->pdo->prepare($sql);

		return $statement->execute([
			":username" => $user->username,
			":email" => $user->email,
			":password" => $user->hash,
			":id" => $user->getId()
		]);
	}

	/**
	 * @param string $email
	 * @return User|null
	 */
	public function findByEmail(string $email): ?User
	{
		$sql = "SELECT * FROM users WHERE email = ?";
		$statement = $this->pdo->prepare($sql);
		$statement->execute([$email]);
		$userData = $statement->fetch(PDO::FETCH_ASSOC);

		if(!$userData) {
			return null;
		}

		return $this->hydrateUser($userData);
	}

	public function upgradePasswordHash(int $id, string $hash): void
	{
		$sql = "UPDATE users SET passsword = :password WHERE id = :id";
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(":password", $hash);
		$statement->bindValue(":id", $id, PDO::PARAM_INT);
		$statement->execute();
	}

	public function emailExists(string $email): bool
	{
		$sql = "SELECT 1 FROM users WHERE email = ? LIMIT 1";
		$statement = $this->pdo->prepare($sql);
		$statement->execute([$email]);
		return (bool) $statement->fetchColumn();
	}
}