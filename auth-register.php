<?php
$pdo = require_once './database/database.php';

$errors = [
  'firstname' => '',
  'lastname' => '',
  'email' => '',
  'password' => '',
  'confirmPassword' => ''
];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(empty(array_filter($errors, fn($e) => $e !== ''))) {
    header('Location: /');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once './includes/head.php'; ?>
    <title>Blogzawesome | Inscription</title>
  </head>
  <body>
    <div class="container">
      <?php require_once './includes/header.php'; ?>
      <div class="content">
        <h1>Inscription</h1>
        <form action="/auth-register.php" method="POST">
          <div class="form-control">
            <label class="form-label" for="firstname">Prénom</label>
            <input classe="form-input" type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
            <?php if($errors['firstname']) : ?>
                <p class="text-error"><?= $errors['firstname'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label class="form-label" for="lastname">Nom</label>
            <input classe="form-input" type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
            <?php if($errors['lastname']) : ?>
                <p class="text-error"><?= $errors['lastname'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label class="form-label" for="email">Email</label>
            <input classe="form-input" type="email" name="email" id="email" value="<?= $email ?? '' ?>">
            <?php if($errors['email']) : ?>
                <p class="text-error"><?= $errors['email'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label class="form-label" for="password">Mot de passe</label>
            <input classe="form-input" type="password" name="password" id="password">
            <?php if($errors['password']) : ?>
                <p class="text-error"><?= $errors['password'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-control">
            <label class="form-label" for="confirmPassword">Confirmer le mot de passe</label>
            <input classe="form-input" type="password" name="confirmPassword" id="confirmPassword">
            <?php if($errors['confirmPassword']) : ?>
                <p class="text-error"><?= $errors['confirmPassword'] ?></p>
            <?php endif; ?>
          </div>
          <div class="form-action">
            <button type="submit" class="btn btn-primary">Valider</button>
            <a class="btn btn-secondary" href="/index.php">Annuler</a>
          </div>
        </form>
      </div>
      <?php require_once './includes/footer.php'; ?>
    </div>
  </body>
</html>