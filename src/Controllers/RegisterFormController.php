<?php

namespace TaskManager\Controllers;

class RegisterFormController implements Controller
{
	public function __construct()
	{
	}

	public function processaRequisicao(): void
	{
		require_once __DIR__ . "/../../views/register-form.php";
	}
}