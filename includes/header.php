<header>
	<a href="/" class="icone">
		<i class="fa-solid fa-cat mr-5"></i>
		Blogzawesome
	</a>
	<ul class="header-menu">
		<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-register.php' ? "active" : '' ?>>
			<a href="/auth-register.php">Inscription</a>
		</li>
		<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-login.php' ? "active" : '' ?>>
			<a href="/auth-login.php">Connexion</a>
		</li>
		<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-logout.php' ? "active" : '' ?>>
			<a href="/auth-logout.php">Déconnexion</a>
		</li>
		<li class=<?= $_SERVER['REQUEST_URI'] === '/profil.php' ? "active" : '' ?>>
			<a href="/profil.php">Ma page</a>
		</li>
		<li class=<?= $_SERVER['REQUEST_URI'] === '/edit-article.php' ? "active" : '' ?>>
			<a href="/edit-article.php" >Ecrire un article</a>
		</li>	
	</ul>
</header>

