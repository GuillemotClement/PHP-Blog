<pre>
<?php 
require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/database/security.php';
$currentUser = isLoggedIn();
// on vient récupérer la classe qui permet de faire les requetes lié à article
$articleDB = require_once './database/models/ArticleDB.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';


if(!$id){
    header('Location: /');
}else{
    // on affiche l'article via la méthode de la classe
    $article = $articleDB->fetchOne($id);
}
?>
</pre>



<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once './includes/head.php'; ?>
    <title>Blogzawesome | Article</title>
</head>
<body>
    <div class="container">
        <?php require_once './includes/header.php'; ?>

        <div class="content">
            <div class="container-article">
                <a href="/" class="container-article-link">Retour a la liste des articles</a>
                <div class="container-article-cover" style="background-image: url(<?= $article['picture']?>)"></div>
                <h1 class="container-article-title"><?= $article['title']?></h1>
                <div class="container-article-separator"></div>
                <p class="container-article-category"><?= $article['category']?></p>
                <p class="container-article-content"><?= $article['content']?></p>
                <p class="article-author"><?= $article['firstname'] . ' ' . $article['lastname']?></p>
            </div>
            <?php if($currentUser && $currentUser['id'] === $article['author']): ?>
                <div class="action">
                    <a href="/delete-article.php?id=<?=$article['id']?>" class="btn btn-danger">Supprimer</a>
                    <a href="/edit-article.php?id=<?=$article['id']?>" class="btn btn-edit">Editer l'article</a>
                </div>
            <?php endif; ?>
        </div>

        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>