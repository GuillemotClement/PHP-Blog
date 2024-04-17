<?php
	$currentUser = $currentUser ?? false;
?>

<header>
	<a href="/" class="icone">
		<i class="fa-solid fa-cat mr-5"></i>
		Blogzawesome
	</a>
	<div class="header-mobile">
		<div class="header-mobile-logo">
			<img src="/public//img//burger.png" alt="">
		</div>
		<ul class="header-mobile-list">
			<?php if($currentUser) : ?>
				<li class=<?= $_SERVER['REQUEST_URI'] === '/edit-article.php' ? "active" : '' ?>>
					<a href="/edit-article.php">Ecrire un article</a>
				</li>
				<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-logout.php' ? "active" : '' ?>>
					<a href="/auth-logout.php">Déconnexion</a>
				</li>
				<li class="<?= $_SERVER['REQUEST_URI'] === '/profil.php' ? "active" : '' ?> profile">
					<a href="/profil.php">Mon espace</a>
				</li>
			<?php else :?>
				<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-login.php' ? "active" : '' ?>>
					<a href="/auth-login.php">Connexion</a>
				</li>
				<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-register.php' ? "active" : '' ?>>
					<a href="/auth-register.php">Inscription</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<ul class="header-menu">
		<?php if($currentUser) : ?>
			<li class=<?= $_SERVER['REQUEST_URI'] === '/edit-article.php' ? "active" : '' ?>>
				<a href="/edit-article.php">Ecrire un article</a>
			</li>
			<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-logout.php' ? "active" : '' ?>>
				<a href="/auth-logout.php">Déconnexion</a>
			</li>
			<li class="<?= $_SERVER['REQUEST_URI'] === '/profil.php' ? "active" : '' ?> profile">
				<a href="/profil.php"><?= $currentUser['firstname'][0] . $currentUser['lastname'][0] ?></a>
			</li>
		<?php else :?>
			<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-login.php' ? "active" : '' ?>>
				<a href="/auth-login.php">Connexion</a>
			</li>
			<li class=<?= $_SERVER['REQUEST_URI'] === '/auth-register.php' ? "active" : '' ?>>
				<a href="/auth-register.php">Inscription</a>
			</li>
		<?php endif; ?>
	</ul>
</header>

