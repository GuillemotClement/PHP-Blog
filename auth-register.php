<?php
$pdo = require_once './database/database.php';

const ERROR_REQUIRED = 'Saisir une valeur pour ce champ';
const ERROR_TOO_SHORT = "Ce champ est trop court";
const ERROR_PASSWORD_TOO_SHORT = 'Le mot de passe doit faire au moins 6 caracteres';
const ERROR_PASSWORD_MISSMATCH = 'Les mot de passe de confirmation est different du mot de passe';
const ERROR_EMAIL_INVALID = 'Email est pas valide';

$errors = [
  'firstname' => '',
  'lastname' => '',
  'email' => '',
  'password' => '',
  'confirmPassword' => ''
];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $input = filter_input_array(INPUT_POST, [
    'firstname'=>FILTER_SANITIZE_SPECIAL_CHARS,
    'lastname'=>FILTER_SANITIZE_SPECIAL_CHARS,
    'email'=>FILTER_SANITIZE_EMAIL
  ]);
  $firstname = $input['firstname'] ?? '';
  $lastname = $input['lastname'] ?? '';
  $email = $input['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirmPassword'] ?? '';

  if(!$firstname){
    $errors['firstname'] = ERROR_REQUIRED;
  }elseif(mb_strlen($firstname) < 2){
    $errors['firstname'] = ERROR_TOO_SHORT;
  }

  if(!$lastname){
    $errors['lastname'] = ERROR_REQUIRED;
  }elseif(mb_strlen($lastname) < 2){
    $errors['lastname'] = ERROR_TOO_SHORT;
  }

  if(!$email){
    $errors['email'] = ERROR_REQUIRED;
  }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = ERROR_EMAIL_INVALID;
  }

  if(!$password){
    $errors['password'] = ERROR_REQUIRED;
  }elseif(mb_strlen($password) < 6){
    $errors['password'] = ERROR_PASSWORD_TOO_SHORT;
  }
  if(!$confirmPassword){
    $errors['confirmPassword'] = ERROR_REQUIRED;
  }elseif($confirmPassword !== $password){
    $errors['confirmPassword'] = ERROR_PASSWORD_MISSMATCH;
  }

  if(empty(array_filter($errors, fn($e) => $e !== ''))) {
    $statementRegister = $pdo->prepare('INSERT INTO user VALUES (
      DEFAULT,
      :firstname,
      :lastname,
      :email,
      :password
    )');
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
    $statementRegister->bindValue(':firstname', $firstname);
    $statementRegister->bindValue(':lastname', $lastname);
    $statementRegister->bindValue(':email', $email);
    $statementRegister->bindValue(':password', $hashedPassword);
    $statementRegister->execute();

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