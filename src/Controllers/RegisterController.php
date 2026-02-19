<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Entity\User;
use TaskManager\Model\Repository\UserRepository;

class RegisterController implements Controller
{
	public function __construct(private UserRepository $userRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
		$password = filter_input(INPUT_POST, "password");

		if (!$username || !$email || !$password) {
			header("Location: /register?error=invalid_fields");
			exit();
		}

		if ($this->userRepository->emailExists($email)) {
			header("Location: /register?error=email_exists");
		}

		$hash = password_hash($password, PASSWORD_ARGON2ID);
		$user = new User($username, $email, $hash);
		if($this->userRepository->add($user)) {
			header("Location: /login?registered=1");
			exit();
		}
	}
}