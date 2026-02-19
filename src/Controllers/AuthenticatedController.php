<?php

namespace TaskManager\Controllers;

abstract class AuthenticatedController implements Controller
{
	protected function requireLogin(): int
	{
		$userId = $_SESSION['user_id'] ?? null;
		if(!$userId) {
			header("Location: /login");
			exit();
		}

		return $userId;
	}
}