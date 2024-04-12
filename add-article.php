<pre>
<?php 

// DECLARATION CONSTANTE MSG D'ERREUR
const ERROR_REQUIRED = "Saisir une valeur";
const ERROR_MIN_LENGTH = "La saisie est inférieur à 3 caractères";
const ERROR_MAX_LENGTH = "La saisie est supérieur à 50 caractères";
$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // filtration des données saisis par l'user
    $_POST = filter_input_array(
        INPUT_POST,
        [
            'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'picture' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'content' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]
    );
    //recupération des données
    $title = $_POST['title'] ?? '';
    $picture = $_POST['picture'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';
};

//validation du formulaire
if(!$title){
    $errors['title'] = ERROR_REQUIRED;
}elseif(mb_strlen($title) < 3){
    $errors['title'] = ERROR_MIN_LENGTH;
}elseif(mb_strlen($title) > 50){
    $errors = ERROR_MAX_LENGTH;
}




?>
</pre>













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
                        <input type="text" name="title" id="title" value="<?= $title ?? '' ?>>
                        <?= $errors['title'] ? '<p style="color: red">'.$errors['title'].'</p>' : "" ?>
                        
                    </div>
                    <div class="form-control">
                        <label for="picture">Image</label>
                        <input type="text" name="picture" id="picture">
                        <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-control">
                        <label for="category">Catégorie</label>
                        <select name="category" id="category">
                            <option value="technology">Technologie</option>
                            <option value="nature">Nature</option>
                            <option value="politic">Politique</option>
                        </select>
                        <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-control">
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content"></textarea>
                        <!-- <p class="text-error"></p> -->
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