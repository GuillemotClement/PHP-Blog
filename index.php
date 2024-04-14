<pre>
<?php

$filename = __DIR__ . '/data/articles.json';
$articles = [];

$category = [];

if(file_exists($filename)){
    $articles = json_decode(file_get_contents($filename), true) ?? [];
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
</pre>


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
            <div class="category-container">
                <?php foreach($category as $cat => $num): ?>
                    <h2><?= $cat ?></h2>
                    <div class="articles-container">
                        <?php foreach($articlePerCategory[$cat] as $a): ?>
                            <div class="article block">
                                <div class="overflow">
                                    <div class="article-picture" style="background-image: url(<?= $a['picture'] ?>"></div>
                                </div>
                                <h3><?= $a['title']?></h3>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        
        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>