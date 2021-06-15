<?php
session_start();

require 'function.php';

if (!isset($_SESSION['auth']['username'])) {
  header('Location: index.php');
  exit;
}

//récupère tous les acteurs pour pouvoir les afficher sur la page
$donnees = getAllActors();
 ?>
 

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>GBAF EXTRANET</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
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
    <form action="disconnection.php" method="post">
       <p><input type="submit" name="disconnect" value="Deconnexion"/></p>
    </form>
    <form action="profile-parameters.php" method="post">
       <p><input type="submit" name="profile" value="Changer mes informations personnelles"/></p>
    </form>
    <div class="content-header">
      <div>
        <p><img class="img-logo" src="images/GBAF.png" alt="Logo"></p>
      </div>
      <div class="content-user">
        <img class="img-user" src="images/user.png" alt="utilisateur">
        <p><?=$_SESSION['auth']['lastname']?> <?=$_SESSION['auth']['firstname']?></p>
      </div>
    </div>
  </section>
  </header>

  <!-- SECTION PRESENTATION -->
  <section id="presentation">
    <h1>Le Groupement Banque Assurance Français (GBAF) réunit
     les 6 groupes français :</h1>

    <!-- liste presentation groupes majeurs -->
    <div class="list-presentation">

      <ul>
        <li>BNP Paribas</li>
        <li>BPCE</li>
        <li>Crédit Agricole</li>
        <li>Crédit Mutuel-CIC</li>
        <li>Société Générale</li>
        <li>La Banque Postale</li>
      <br>
      <br>
      <br>
<p>Cet Extranet a été spécialement conçu afin d'optimiser les échanges entre employés du groupes GBAF.</p>

      </ul>
    </div>

  </section>

  <!--  ILLUSTRATION -->
  <section id="illustration">
    <p><img class="img-extranet" src="images\extranet.jpg" alt=""></p>

  </section>

  <!-- ACTEURS -->
  <section id="acteurs">

    <h2>Voici les acteurs partenaires du GBAF</h2>

    <div>

      <ul class="list-acteurs">
        <?php foreach ($donnees as $key => $value): ?>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- parties avec logo -->
    <div class="style-acteurs">
<?php foreach ($donnees as $key => $value): ?>
  <div class="display-acteurs">
    <img class="logo-acteurs" src="images/<?= $value["filename"]?>" alt="Logo du partenaire <?=$value["title"]?>">
    <div>
      <h2 class="spanCouleur"><?=ucfirst($value["title"])?></h2>

      <p><?= $value["description_short"]?></p>
    </div>
  </div>

  <div class="lien-droite">
    <a class="lien-acteurs" href="detail-acteur.php?id=<?= $value["id"]?> ">Lire la suite.</a>
  </div>
<?php endforeach; ?>

    </div>

  </section>

  <!-- FOOTER -->
  <footer id="footer">
    <a href="copyright.php" title="Mentions légales / Contact"> Mentions légales / Contact </a>
  </footer>


</body>

</html>