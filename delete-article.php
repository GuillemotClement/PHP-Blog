<?php

$articleDB = require_once './database/models/ArticleDB.php';

//recuperation de l'id via l'url et sanitarization
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

//si on as un id on bind, et on execute la requete
if($id){
    $articleDB->deleteOne($id);
}
header('Location: /');

