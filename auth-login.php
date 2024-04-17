<?php
$pdo = require_once './database/database.php';

const ERROR_REQUIRED = 'Saisir une valeur pour ce champ';
const ERROR_PASSWORD_TOO_SHORT = 'Le mot de passe doit faire au moins 6 caracteres';
const ERROR_PASSWORD_MISSMATCH = 'Le mot de passe non valide';
const ERROR_EMAIL_INVALID = 'Email est pas valide';
const ERROR_EMAIL_UNKNOW = "Email inconnu";

$errors = [
  'email' => '',
  'password' => '',
];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $input = filter_input_array(INPUT_POST, [
    'email'=>FILTER_SANITIZE_EMAIL
  ]);
 
  $email = $input['email'] ?? '';
  $password = $_POST['password'] ?? '';
 
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
 
  if(empty(array_filter($errors, fn($e) => $e !== ''))) {
    $statementUser = $pdo->prepare('SELECT * FROM user WHERE email=:email');
    $statementUser->bindValue(':email', $email);
    $statementUser->execute();
    $user = $statementUser->fetch();

    if(!$user){
      $errors['email'] = ERROR_EMAIL_UNKNOW;
    }else{
      if(!password_verify($password, $user['password'])){
        $errors['password'] = ERROR_PASSWORD_MISSMATCH;
      }else{
        $statementSession = $pdo->prepare('INSERT INTO session VALUES (
          DEFAULT,
          :userid
        )');
        $statementSession->bindValue(':userid', $user['id']);
        $statementSession->execute();
        $sessionId = $pdo->lastInsertId();
        setcookie('session', $sessionId, time() + 60 * 60 *24 *14, '', '', false, true);
        header('Location: /');
      }
    }
    
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once './includes/head.php'; ?>
    <title>Blogzawesome | Connexion</title>
  </head>
  <body>
    <div class="container">
      <?php require_once './includes/header.php'; ?>
      <div class="content">
        <h1>Inscription</h1>
        <form action="/auth-login.php" method="POST">
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