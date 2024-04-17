<?php
require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/database/security.php';
$currentUser = isLoggedIn();

if($currentUser){
    $articleDB = require_once './database/models/ArticleDB.php';
    //recuperation de l'id via l'url et sanitarization
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';

    //si on as un id on bind, et on execute la requete
    if($id){
        $article = $articleDB->fetch($id);
        if($article['author'] === $currentUser['id']){
            $articleDB->deleteOne($id);
        }
    }
}
header('Location: /');

