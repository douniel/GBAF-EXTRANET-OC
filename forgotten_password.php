<?php

session_start();

require 'function.php';

if (isset($_SESSION['auth']['username'])) {
  header('Location: acteurs.php');
  exit;
}

$error = 0;
$msgError = [];
$resultat = '';

if (!empty($_POST['forgottenPwd'])) {

    if (empty($_POST['username'])) {
        $msgError['username'] = "Le champs 'pseudo' est vide";
        $error++;
    }

    if ($error === 0) {
        $username = htmlspecialchars($_POST['username']);

        //sql requete pour retrouver le compte correspondant
        $resultat = getAccount($username);

        if ($resultat)
        {
          $_SESSION['msg'] = 'Veuillez répondre à votre question secrète';
          $_SESSION['auth']['id'] = $resultat['id'];
          $_SESSION['db']['answer'] = $resultat['answer'];

        } else {
                $_SESSION['msg'] = 'Veuillez rentrer un pseudo existant';
        }
    } else {
            $_SESSION['msg'] = 'Veuillez rentrer un pseudo existant';
    }

}


if (!empty($_POST['response'])) {

  if (empty($_POST['answer'])) {
      $msgError['answer'] = "Le champs 'réponse secrète' est vide";
      $error++;
  }

  if (empty($_POST['password'])) {
      $msgError['password'] = "Le champs 'mot de passe' est vide";
      $error++;
  } elseif (strlen($_POST['password']) > 12) {
      $msgError['password'] = "Le mot de passe est trop long (12 caractères max)";
      $error++;
  }

  if ($error === 0) {

        if ($_SESSION['db']['answer'] == $_POST['answer']) {

          //requete sql pour update MDP avec fonction de chiffrage
          $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
          $id = $_SESSION['auth']['id'];
          updatePassword($password, $id);

          $_SESSION['msg'] = "Votre mot de passe a bien été mis a jour";
          header('Location: index.php');

    } else {
         $_SESSION['msg'] = 'La réponse ne correspond pas, veuillez recommencer';
    }

  } else {
    $_SESSION['msg'] = 'Vous avez oublié de remplir des champs, veuillez entrer votre pseudo à nouveau';
  }
}

//if de verification si existe, non null
//if (
//((isset($_POST['username'])) AND ($_POST['username'] !=null))
//AND ((isset($_POST['password'])) AND ($_POST['password'] !=null))
//)

//Si VAR existent
//{
//  $req = $bdd->prepare('SELECT id, password FROM accounts WHERE username = " ' .$_POST['username'] . ' " ');

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page de connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tablett.css" media="screen and (min-width: 425px)">
    <link rel="stylesheet" type="text/css" href="css/desktop.css" media="screen and (min-width: 769px)">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
  </head>
  <body>

    <?php if (isset($_SESSION['msg'])) : ?>

      <p><?= $_SESSION['msg']; ?></p>

    <?php
    unset($_SESSION['msg']);
    endif;
    ?>

    <!-- HEADER -->
    <header>
    <section id="header-site">
      <div class="content-header">
        <a href="/index.php"> <img src="images/GBAF.png" alt="Logo"></a>
        <div class="content-user">
          <img class="img-user" src="images/user.png" alt="utilisateur">
          <p>Nom / Pr&eacutenom</p>
        </div>
      </div>
    </section>
    </header>

    <h1>MODIFICATION MOT DE PASSE</h1>

      <p>
        Entrez votre pseudo:
      </p>
      <form method="post">

        <p>
          <label for="username">PSEUDO: </label>
          <input type="text" name="username" id="username" value="<?= !empty($_POST['username']) ? $_POST['username'] : '' ?>" />
          <p class="<?= !empty($msgError['username']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['username']) ? $msgError['username'] : '' ?></p>
        </p>

        <input type="submit" value="Envoyer" name="forgottenPwd">

      </form>


  <?php if ($resultat) : ?>



    <p>
      QUESTION SECRETE : <?=$resultat["question"]?>
    </p>
    <form method="post">

      <p>
        <label for="answer">REPONSE </label>
        <input type="text" name="answer" id="answer" value="<?= !empty($_POST['answer']) ? $_POST['answer'] : '' ?>" />
        <span class="<?= !empty($msgError['answer']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['answer']) ? $msgError['answer'] : '' ?></span>
      </p>

      <p>
        <label for="password">NOUVEAU MOT DE PASSE: </label>
        <input type="password2" name="password" id="password"/>
        <span class="<?= !empty($msgError['password']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['password']) ? $msgError['password'] : '' ?></span>
      </p>

      <input type="submit" value="Envoyer" name="response">

    </form>

    <?php endif; ?>





    <!-- FOOTER -->
    <footer id="footer">
    <a href="https://fr.wikipedia.org/wiki/Copyright title="Mentions légales / Contact"> Mentions légales / Contact </a>
  </footer>


  </body>
</html>