<?php
// permet de proteger le mot de passe et 
// $usr = getenv('DB_USER');
// $pwd = getenv('DB_PWD');
// On viendras préciser lors du lancement du serveur les variable d'env
// DB_USER='userName' DB_PWD='pwd' php -S localhost:3000



// $dns = 'mysql:host=localhost;dbname=bog';
$dns = 'mysql:host=localhost;dbname=blog';
$usr = 'root';


$pwd = '849Tcmh@uvfk';


try{
    $pdo = new PDO($dns, $usr, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);   
}catch(PDOException $e){
    echo 'Error DB : ' . $e->getMessage();
}

return $pdo;
