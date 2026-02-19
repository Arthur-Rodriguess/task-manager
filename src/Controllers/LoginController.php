<?php

namespace TaskManager\Controllers;

use TaskManager\Model\Repository\UserRepository;

class LoginController implements Controller
{
	public function __construct(private UserRepository $userRepository)
	{
	}

	public function processaRequisicao(): void
	{
		$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
		$password = filter_input(INPUT_POST, "password");

		if(!$email || !$password) {
			header("Location: /login?error=invalid_fields");
			exit();
		}

		$user = $this->userRepository->findByEmail($email);
		if (!$user) {
			header("Location: /login?login_success=0");
			exit();
		}

		if(password_verify($password, $user->hash ?? '')) {
			// Caso a senha do usuário esteja com um hash diferente desse algoritmo irá ser mudada pra esse novo algoritmo
			if(password_needs_rehash($user->hash, PASSWORD_ARGON2ID)) {
				$newHash = password_hash($password, PASSWORD_ARGON2ID);
				$this->userRepository->upgradePasswordHash($user->getId(), $newHash);
			}

			$_SESSION['logado'] = true;
			$_SESSION['user_id'] = $user->getId();
			header("Location: /?login_success=1");
		} else {
			header("Location: /login?login_success=0");
			exit();
		}
	}
}