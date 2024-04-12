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
                        <input type="text" name="title" id="title">
                        <!-- <p class="text-error"></p> -->
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
                        <button class="btn btn-primary" type="button">Sauvegarder</button>
                        <a class="btn btn-secondary" type="button" href="/">Annuler</a>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once './includes/footer.php'; ?>
    </div>
</body>
</html>