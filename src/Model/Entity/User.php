<?php

namespace TaskManager\Model\Entity;

class User
{
	private ?int $id = null;

	public function __construct(
		public readonly string $username,
		public readonly string $email,
		public readonly string $hash
	)
	{
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getId(): ?int
	{
		return $this->id;
	}
}