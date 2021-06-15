<?php
session_start();

require 'function.php';

if (isset($_SESSION['auth']['username'])) {
  header('Location: acteurs.php');
  exit;
}


$error = 0;
$msgError = [];

if (!empty($_POST['register'])) {

  $firstname = htmlspecialchars( $_POST['firstname']);
  $lastname = htmlspecialchars( $_POST['lastname']);
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  $question = htmlspecialchars($_POST['question']);
  $answer = htmlspecialchars($_POST['answer']);

    if (empty($firstname)) {
        $msgError['firstname'] = "Le champs 'prénom' est vide";
        $error++;
    } elseif (strlen($firstname) > 20) {
        $msgError['firstname'] = "Le prénom est trop long (20 caractères max)";
        $error++;
    }

    if (empty($lastname)) {
        $msgError['lastname'] = "Le champs 'nom' est vide";
        $error++;
    } elseif (strlen($lastname) > 20) {
        $msgError['lastname'] = "Le nom est trop long (20 caractères max)";
        $error++;
    }

    if (empty($username)) {
        $msgError['username'] = "Le champs 'pseudo' est vide";
        $error++;
    } elseif (strlen($username) > 12) {
        $msgError['username'] = "Le pseudo est trop long (12 caractères max)";
        $error++;
    }

    if (empty($password)) {
        $msgError['password'] = "Le champs 'mot de passe' est vide";
        $error++;
    } elseif (strlen($password) > 12) {
        $msgError['password'] = "Le mot de passe est trop long (12 caractères max)";
        $error++;
    }
    if (empty($question)) {
        $msgError['question'] = "Le champs 'question secrète' est vide";
        $error++;
    } elseif (strlen($question) > 25) {
        $msgError['question'] = "Le question secrète est trop longue (25 caractères max)";
        $error++;
    }

    if (empty($answer)) {
        $msgError['answer'] = "Le champs 'réponse secrète' est vide";
        $error++;
    } elseif (strlen($answer) > 20) {
        $msgError['answer'] = "La réponse secrète est trop longue (20 caractères max)";
        $error++;
    }

    //insert pour enregistrer le nouvel utilisateur en DB
    if ($error === 0) {
      try {
        register($username, $password, $firstname, $lastname, $answer, $question);

        $_SESSION['msg'] = "Votre compte a bien été créé";
      }

      catch (Exception $e)
      {

              $_SESSION['msg'] = "Vous avez déjà un compte existant";
      }

    }

}

 ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page d'inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tablett.css" media="screen and (min-width: 425px)">
    <link rel="stylesheet" type="text/css" href="css/desktop.css" media="screen and (min-width: 769px)">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
  </head>

  <body>

    <?php if (isset($_SESSION['msg'])) : ?>

      <p><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></p>

    <?php endif; ?>


    <!-- SECTION HEADER -->
    <header>
    <section id="header-site">
      <div class="content-header">
        <div>
        <a href="/acteurs.php"> <img src="images/GBAF.png" alt="Logo"></a>
        </div>
        <div class="content-user">
          <img class="img-user" src="images/user.png" alt="utilisateur">
          <p>Nom / Pr&eacutenom</p>
        </div>
      </div>
    </section>
    </header>

    <h1>CREATION DE MON COMPTE </h1>

<!-- formulaire  d'inscription -->
    <form method="post">
      <div class="formulaire">
      <p>
        <label for="firstname">PRENOM: </label>
        <input type="text" name="firstname" id="firstname" value="<?= !empty($_POST['firstname']) ? $_POST['firstname'] : '' ?>" />
        <span class="<?= !empty($msgError['firstname']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['firstname']) ? $msgError['firstname'] : '' ?></span>
      </p>

      <p>
        <label for="lastname">NOM: </label>
        <input type="text" name="lastname" id="lastname" value="<?= !empty($_POST['lastname']) ? $_POST['lastname'] : '' ?>" />
        <span class="<?= !empty($msgError['lastname']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['lastname']) ? $msgError['lastname'] : '' ?></span>
      </p>

      <p>
        <label for="username">PSEUDO: </label>
        <input type="text" name="username" id="username" value="<?= !empty($_POST['username']) ? $_POST['username'] : '' ?>" />
        <span class="<?= !empty($msgError['username']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['username']) ? $msgError['username'] : '' ?></span>
      </p>

      <p>
        <label for="password">MOT DE PASSE: </label>
        <input type="password" name="password" id="password"/>
        <span class="<?= !empty($msgError['password']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['password']) ? $msgError['password'] : '' ?></span>
      </p>

      <p>
        <label for="question">QUESTION SECRETE: </label>
        <input type="text" name="question" id="question" value="<?= !empty($_POST['question']) ? $_POST['question'] : '' ?>" />
        <span class="<?= !empty($msgError['question']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['question']) ? $msgError['question'] : '' ?></span>
      </p>

      <p>
        <label for="answer">REPONSE: </label>
        <input type="text" name="answer" id="answer" value="<?= !empty($_POST['answer']) ? $_POST['answer'] : '' ?>" />
        <span class="<?= !empty($msgError['answer']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['answer']) ? $msgError['answer'] : '' ?></span>
      </p>
    </div>
      <input type="submit" name="register" value="Valider"/>
      </form>

      <!-- FOOTER -->
      <footer id="footer">
    <a href="https://fr.wikipedia.org/wiki/Copyright title="Mentions légales / Contact"> Mentions légales / Contact </a>
  </footer>



    </body>
  </html>