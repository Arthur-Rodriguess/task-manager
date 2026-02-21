<?php

namespace TaskManager\Controllers;

class LogoutController implements Controller
{
	public function __construct()
	{
	}

	public function processaRequisicao(): void
	{
		if(empty($_SESSION['user'])) {
			header("Location: /login");
			exit();
		}

		session_destroy();

		header("Location: /login?logout=1");
		exit();
	}
}