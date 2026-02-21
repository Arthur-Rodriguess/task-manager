<aside id="sidebar" class="sidebar">
	<div class="sidebar-header">
		<img src="img/avatar.png" width="70">
		<strong><?= $_SESSION['user']->name ?></strong>
	</div>

	<nav class="sidebar-nav">
		<a href="/logout" class="logout-btn">Sair</a>
	</nav>
</aside>

<div id="overlay" class="overlay"></div>