<?php

$articles = json_decode(file_get_contents('./articles.json'), true);

$dns = 'mysql:host=localhost;dbname=bog';
$usr = 'root';
$pwd = '849Tcmh@uvfk';


$pdo = new PDO($dns, $usr, $pwd);

$statement = $pdo->prepare('
    INSERT INTO article (
        title,
        category,
        content,
        picture
    ) VALUES 
    (
        :title,
        :category,
        :content,
        :picture
    )');

foreach($articles as $article){
    $statement->bindValue(':title', $article['title']);
    $statement->bindValue(':category', $article['category']);
    $statement->bindValue(':content', $article['content']);
    $statement->bindValue(':picture', $article['picture']);
    $statement->execute();
}
