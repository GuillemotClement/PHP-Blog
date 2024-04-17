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
			<h1>Un problème est survenue</h1>
		</div>     
	</div>
		<?php require_once './includes/footer.php'; ?>
	</div>
</body>
</html>