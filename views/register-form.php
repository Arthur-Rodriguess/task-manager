<?php require_once __DIR__ . "/header-html.php"; ?>
	<main>
		<h1 class="form-title">Realize o seu Login</h1>
		<form method="post" class="form">
			<input type="text" name="username" placeholder="Nome do usuário">
			<input type="email" name="email" placeholder="E-mail do usuário">
			<input type="password" name="password" placeholder="Senha do usuário">
			<input type="submit" id="submit-button" value="Entrar">
			<p class="form-text">Já criou uma conta? <a href="/login">Faça seu login</a></p>
		</form>
	</main>
<?php require_once __DIR__ . "/footer-html.php";