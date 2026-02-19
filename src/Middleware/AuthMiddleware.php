<?php

namespace TaskManager\Middleware;

class AuthMiddleware
{
	public static function handle(): void
	{
		if(!isset($_SESSION['logado'])) {
			header("Location: /login");
		}
	}
}