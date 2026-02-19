<?php

namespace TaskManager\Controllers;

class LoginFormController implements Controller
{
	public function __construct()
	{
	}

	public function processaRequisicao(): void
	{
		require_once __DIR__ . "/../../views/login-form.php";
	}
}