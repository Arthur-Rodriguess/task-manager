<?php

namespace TaskManager\Controllers;

class Error404Controller implements Controller
{
	public function processaRequisicao(): void
	{
		require_once __DIR__ . "/../../views/not-found-404.php";
	}
}