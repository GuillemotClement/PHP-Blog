
<?php 


// DECLARATION CONSTANTE MSG D'ERREUR
const ERROR_REQUIRED = "Saisir une valeur";
const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
const ERROR_CONTENT_TOO_SHORT = 'Article trop court';
const ERROR_PIC_URL = 'Image doit etre une url valide';

// DECLARATION DU FILENAME POUR STOCKER LES DONNEES
$filename = __DIR__ . '/data/articles.json';

// INITIALISATION TABLEAU ERREURS
$errors = [
    'title' => '',
    'picture' => '',
    'category' => '',
    'content' => ''
];

// on verifie que le fichier existe
if(file_exists($filename)){
    // si il existe on le decode et on recupere les donnes
    $articles = json_decode(file_get_contents($filename), true) ?? [];
}



//VERIFICATION METHODE ENVOI
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // filtration des données saisis par l'user
    $_POST = filter_input_array(
        INPUT_POST,
        [
            'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'picture' => FILTER_SANITIZE_URL,
            'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'content' => [
                'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
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
        $articles = [...$articles, [
            'title' => $title,
            'picture' => $picture,
            'category' => $category,
            'content' => $content,
            'id' => time(),
        ]];
        //encode et on ecrase ancien fichier
        $jsonData = json_encode($articles);



        file_put_contents($filename, json_encode($articles));
        //on renvoie user vers l'accueil
        header('Location: /');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once './includes/head.php'; ?>
    <title>Blogzawesome | Créer un article</title>
</head>
<body>
    <div class="container">
        <?php require_once './includes/header.php'; ?>

        <div class="content">
            <div class="block p-20 form-container">
                <h1>Ajouter un article</h1>
                <form action="/add-article.php" method="post">
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
                            <option value="technology">Technologie</option>
                            <option value="nature">Nature</option>
                            <option value="sport">Sport</option>
                        </select>
                        <?php if($errors['category']) : ?>
                            <p class="text-error"><?= $errors['category'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content" value="<?= $content ?? '' ?>"></textarea>
                        <?php if($errors['content']) : ?>
                            <p class="text-error"><?= $errors['content'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-action">
                        <button type="submit" class="btn btn-primary" type="button">Sauvegarder</button>
                        <a class="btn btn-secondary" type="button" href="/">Annuler</a>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>