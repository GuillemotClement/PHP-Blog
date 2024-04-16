<?php
// recupération de l'objet pdo
$pdo = require_once './database.php';

//preparation de la requete
$statement = $pdo->prepare('DELETE FROM article WHERE id=:id');

//recuperation de l'id via l'url et sanitarization
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

//si on as un id on bind, et on execute la requete
if($id){
    $statement->bindValue(':id', $id);
    $statement->execute();
}
header('Location: /');

