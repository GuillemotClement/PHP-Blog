<?php 
require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/database/security.php';

$currentUser = isLoggedIn();

if(!$currentUser){
    header('Location: /');
}

$articleDB = require_once './database/models/ArticleDB.php';

// DECLARATION CONSTANTE MSG D'ERREUR
const ERROR_REQUIRED = "Saisir une valeur";
const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
const ERROR_CONTENT_TOO_SHORT = 'Article trop court';
const ERROR_PIC_URL = 'Image doit etre une url valide';

// INITIALISATION TABLEAU ERREURS
$errors = [
    'title' => '',
    'picture' => '',
    'category' => '',
    'content' => ''
];
$category = '';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';
if($id){
    $article = $articleDB->fetchOne($id);
    if(!$article['author'] !== $currentUser['id']){
        header('Location: /');
    }
    $title = $article['title'];
    $picture = $article['picture'];
    $category = $article['category'];
    $content = $article['content'];
}

//VERIFICATION METHODE ENVOI
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // filtration des données saisis par l'user
    $_POST = filter_input_array(
        INPUT_POST,
        [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'picture' => FILTER_SANITIZE_URL,
            'category' => FILTER_SANITIZE_SPECIAL_CHARS,
            'content' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                'flag' => FILTER_FLAG_NO_ENCODE_QUOTES
            ],
        ]);
    //recupération des données
    $title = $_POST['title'] ?? '';
    $picture = $_POST['picture'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';

    // VALIDATION DES DONNES DU FORMULAIRE
    if(!$title){
        $errors['title'] = ERROR_REQUIRED;
    }elseif(mb_strlen($title) < 5){
        $errors['title'] = ERROR_TITLE_TOO_SHORT;
    }

    if(!$picture){
        $errors['picture'] = ERROR_REQUIRED;
    }elseif(!filter_var($picture, FILTER_VALIDATE_URL)){
        $errors['picture'] = ERROR_PIC_URL;
    }

    if(!$category){
        $errors['category'] = ERROR_REQUIRED;
    }

    if(!$content){
        $errors['content'] = ERROR_REQUIRED;
    }elseif(mb_strlen($content) < 10){
        $errors['content'] = ERROR_CONTENT_TOO_SHORT;
    }

    // VERIF $ERRORS VIDE
    // on utiliser la methode pour verifier que le tableau est vide
    // $e represente l'iteration en cours
    // cela permet de retourner une erreur si une valeur est dans le tableau d'erreurs
    // la methode retourne un nouveau tableau si une erreur est ajouter dans le tableau d'erreur

    // empty verifie que le tableau est vide
    //si il est vide, alors on rentre dans le if
    if(empty(array_filter($errors, fn($e) => $e !== ''))){
        //on recup les donnes du nouvel article et on ajoute dans le tableau d'article
        if($id){
            $article['title'] = $title;
            $article['picture'] = $picture;
            $article['category'] = $category;
            $article['content'] = $content;
            $article['author'] = $currentUser['id'];
            $articleDB->updateOne($article);
        } else {
        $articleDB->createOne([
            'title'=>$title,
            'content'=>$content,
            'category'=>$category,
            'picture'=>$picture,
            'author'=>$currentUser['id']
            ]);
        }
        //on renvoie user vers l'accueil
        header('Location: /');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once './includes/head.php'; ?>
    <title><?= $id ? 'Modifier un article' : 'Creer un nouvel article' ?></title>
</head>
<body>
    <div class="container">
        <?php require_once './includes/header.php'; ?>
        
        <div class="content">
            <h1><?= $id ? 'Modifier un article' : 'Creer un nouvel article' ?></h1>
            <div class="block p-20 form-container">
                
                <form action="/edit-article.php<?= $id ? "?id=$id" : ''?>" method="post">
                    <div class="form-control">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="<?= $title ?? '' ?>">
                        <?php if($errors['title']) : ?>
                            <p class="text-error"><?= $errors['title'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="picture">Image</label>
                        <input type="text" name="picture" id="picture" value="<?= $picture ?? '' ?>">
                        <?php if($errors['picture']) : ?>
                            <p class="text-error"><?= $errors['picture'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="category">Catégorie</label>
                        <select name="category" id="category">
                            <option <?= !$category || $category === 'technology' ? 'selected':'' ?> value="technology">Technologie</option>
                            <option <?=$category === 'nature' ? 'selected':'' ?> value="nature">Nature</option>
                            <option <?=$category === 'sport' ? 'selected':'' ?> value="sport">Sport</option>
                        </select>
                        <?php if($errors['category']) : ?>
                            <p class="text-error"><?= $errors['category'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content"><?= $content ?? '' ?></textarea>
                        <?php if($errors['content']) : ?>
                            <p class="text-error"><?= $errors['content'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-action">
                        <button type="submit" class="btn btn-primary"><?= $id ? 'Modifier' : 'Sauvegarder' ?></button>
                        <a class="btn btn-secondary" type="button" href="/">Annuler</a>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>