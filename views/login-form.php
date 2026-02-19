<?php require_once __DIR__ . "/header-html.php"; ?>
	<main>
        <h1 class="form-title">Realize o seu Login</h1>
		<form method="post" class="form">
			<input type="email" name="email" placeholder="E-mail do usuário" required>
			<input type="password" name="password" placeholder="Senha do usuário" required>
			<input type="submit" id="submit-button" value="Entrar">
			<p class="form-text">Ainda não tem uma conta? <a href="/register">Crie uma aqui</a></p>
		</form>
	</main>
<?php require_once __DIR__ . "/footer-html.php";