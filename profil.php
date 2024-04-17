<?php 
require_once __DIR__ . '/database/database.php';
$authDB = require __DIR__ . '/database/security.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
$articles = [];
$currentUser = $authDB->isLoggedIn();


if(!$currentUser){
    header('Location: /');
}

$articles = $articleDB->fetchUserArticle($currentUser['id']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once './includes/head.php'; ?>
    <title>Blogzawesome | Profil</title>
  </head>
<body>
  <div class="container">
    <?php require_once './includes/header.php'; ?>
    <div class="content">
      <h1>Mon espace</h1>
      <h2>Mes informations</h2>
      <div class="container-info">
        <ul>
          <li>
            <strong>Prénom :</strong>
            <p><?= $currentUser['firstname'] ?></p>
          </li>
          <li>
            <strong>Nom :</strong>
            <p><?= $currentUser['lastname'] ?></p>
          </li>
          <li>
            <strong>Email :</strong>
            <p><?= $currentUser['email'] ?></p>
          </li>
        </ul>
      </div>
      <h2>Mes articles</h2>
        <div class="articles-list">
          <ul>
            <?php foreach($articles as $article): ?>
            <li>
              <span><?= $article['title']?></span>
              <div class="article-action">
                <a class="btn btn-primary" href="/edit-article.php?id=<?=$article['id']?>">Modifier</a>
                <a class="btn btn-danger" href="/delete-article.php?id=<?=$article['id']?>">Supprimer</a>
              </div>
            </li>
            <?php endforeach?>
          </ul>
        </div>
    </div>
    <?php require_once './includes/footer.php'; ?>
  </div>
</body>
</html>