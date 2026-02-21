<?php

namespace TaskManager\Controllers;

abstract class AuthenticatedController implements Controller
{
	protected function requireLogin(): int
	{
		$user = $_SESSION['user'] ?? null;
		if(!$user) {
			header("Location: /login");
			exit();
		}

		return $user->id;
	}
}