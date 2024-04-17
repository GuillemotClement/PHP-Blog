<?php
require __DIR__ . '/database/database.php';
$authDB = require __DIR__ . '/database/security.php';
$currentUser = $authDB->isLoggedIn();

$articleDB = require_once './database/models/ArticleDB.php';
$articles = $articleDB->fetchAll();
$category = [];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

if(count($articles)){
	$cattmp = array_map(fn($a) => $a['category'], $articles);
	$category = array_reduce($cattmp, function($acc, $cat){
		if(isset($acc[$cat])){
			$acc[$cat]++;
		}else{
			$acc[$cat] = 1;
		}
		return $acc;
	},[]);
	$articlePerCategory = array_reduce($articles, function($acc, $article){
		if(isset($acc[$article['category']])){
			$acc[$article['category']] = [...$acc[$article['category']], $article];
		}else{
			$acc[$article['category']] = [$article];
		}
		return $acc;
	}, []);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once './includes/head.php'; ?>
	<title>Blogzawesome | Accueil</title>
</head>
<body>
	<div class="container">
		<?php require_once './includes/header.php'; ?>
		<div class="content">
			<div class="newsfeed-container">
				<ul class="category">
					<li class=<?= $selectedCat ? "" : "cat-active"?>><a href="/">Tous les articles <span class="small">(<?= count($articles) ?>)</span></a></li>
					<?php foreach($category as $catName => $catNum) :?>
						<li class=<?= $selectedCat === $catName ? "cat-active" : ""?>><a href="/?cat=<?= $catName ?>"><?= $catName ?><span class="small"><?= $catNum ?></span></a></li>
					<?php endforeach;?>
				</ul>
				<div class="article">
					<?php  if(!$selectedCat):?>
					<?php foreach($category as $cat => $num): ?>
						<h2><?= $cat ?></h2>
						<div class="articles-container">
							<?php foreach($articlePerCategory[$cat] as $a): ?>
								<a class="article block" href="/show-article.php?id=<?= $a['id']?>">
									<div class="overflow">
										<div class="article-picture" style="background-image: url(<?= $a['picture'] ?>"></div>
									</div>
									<h3><?= $a['title']?></h3>
									<?php if($a['author']) : ?>
										<div class="article-author">
											<p><?= $a['firstname'] . ' ' . $a['lastname'] ?></p>
										</div>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
					<?php else : ?>
						<h2><?= $selectedCat ?></h2>
						<div class="articles-container">
							<?php foreach($articlePerCategory[$selectedCat] as $a): ?>
								<a class="article block" href="/show-article.php?id=<?= $a['id']?>">
									<div class="overflow">
										<div class="article-picture" style="background-image: url(<?= $a['picture'] ?>"></div>
									</div>
									<h3><?= $a['title']?></h3>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div> 
		</div>     
	</div>
		<?php require_once './includes/footer.php'; ?>
	</div>
</body>
</html>