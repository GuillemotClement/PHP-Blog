<pre>
<?php 

$filename = __DIR__ . "/data/articles.json";
$articles = [];
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

//si pas d'id, on redirige vers l'accueil
if(!$id){
    header('Location: /');
}else{
    if(file_exists($filename)){
        $articles = json_decode(file_get_contents($filename), true) ?? [];
        $articleIndex = array_search($id, array_column($articles, 'id'));
        $article = $articles[$articleIndex];

    }
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
            </div>
            <div class="action">
                <a href="/delete-article.php?id=<?=$article['id']?>" class="btn btn-danger">Supprimer</a>
                <a href="/edit-article.php?id=<?=$article['id']?>" class="btn btn-edit">Editer l'article</a>
            </div>
            
        </div>

        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>