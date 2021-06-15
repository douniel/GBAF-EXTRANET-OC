<?php
session_start();

require 'function.php';

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
      <a href="/acteurs.php"> <img src="images/GBAF.png" alt="Logo"></a>
      </div>
      <div class="content-user">
        <img class="img-user" src="images/user.png" alt="utilisateur">
        <p><?=$_SESSION['auth']['lastname']?> <?=$_SESSION['auth']['firstname']?></p>
      </div>
    </div>
  </section>
  </header>

  <body>
    <p>Mentions légales
En vigueur au 14/06/2021
Conformément aux dispositions des Articles 6-III et 19 de la Loi n°2004-575 du 21 juin 2004 pour la
Confiance dans l’économie numérique, dite L.C.E.N., il est porté à la connaissance des Utilisateurs du
site gbaf les présentes mentions légales.
La connexion et la navigation sur le site (indiquer le nom du site) par l’Utilisateur implique acceptation
intégrale et sans réserve des présentes mentions légales.
Ces dernières sont accessibles sur le site à la rubrique « Mentions légales ».
ARTICLE 1 : L’éditeur
L’édition et la direction de la publication du site gbaf est assurée par Daniel MILHANO FERARU,
domiciliée 10 rue des prés, dont le numéro de téléphone est 0712345678, et l'adresse e-mail
d_feraru@yahoo.fr.
ARTICLE 2 : L’hébergeur
L'hébergeur du site gbaf est la Société _______________, dont le siège social est situé au
_______________ , avec le numéro de téléphone : _______________.
ARTICLE 3 : Accès au site
Le site est accessible par tout endroit, 7j/7, 24h/24 sauf cas de force majeure, interruption
programmée ou non et pouvant découlant d’une nécessité de maintenance.
En cas de modification, interruption ou suspension des services le site gbaf ne saurait être tenu
responsable.
ARTICLE 4 : Collecte des données
Le site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le respect
de la vie privée conformément à la loi n°78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers
et aux libertés. Le site est déclaré à la CNIL sous le numéro _______________.
En vertu de la loi Informatique et Libertés, en date du 6 janvier 1978, l'Utilisateur dispose d'un droit
d'accès, de rectification, de suppression et d'opposition de ses données personnelles. L'Utilisateur
exerce ce droit :
· via son espace personnel ;
1
ARTICLE 5 : Cookies
L’Utilisateur est informé que lors de ses visites sur le site, un cookie peut s’installer automatiquement
sur son logiciel de navigation.
En naviguant sur le site, il les accepte.
Un cookie est un élément qui ne permet pas d’identifier l’Utilisateur mais sert à enregistrer des
informations relatives à la navigation de celui-ci sur le site Internet. L’Utilisateur pourra désactiver ce
cookie par l’intermédiaire des paramètres figurant au sein de son logiciel de navigation.
ARTICLE 6 : Propriété intellectuelle
Toute utilisation, reproduction, diffusion, commercialisation, modification de toute ou partie du site
gbaf, sans autorisation de l’Editeur est prohibée et pourra entraînée des actions et poursuites
judiciaires telles que notamment prévues par le Code de la propriété intellectuelle et le Code civil. </p>
  </body>