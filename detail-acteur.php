<?php
session_start();

require 'function.php';

if (!isset($_SESSION['auth']['username'])) {
  header('Location: index.php');
  exit;
}

 ?>


<?php //ajouter id superieur ou egal a 0
if(isset($_GET['id']))
{
    $idActeur = (int) $_GET['id'];
    //query
    $actor = getActor($idActeur);

    $idAccount = $_SESSION['auth']['id'];

//requete sql pour récupérer le total des votes pour cet utilisateur et concernant cet acteur
    $votes = getTotalVotes($idActeur, $idAccount);


} else {
    $_SESSION['msg'] = "Partenaire introuvable";
  	header('Location: acteurs.php');
}

$error = 0;
$msgError = [];

// récupérer l'id de l'acteur
$idActeur = (int) $_GET['id'];
// récupérer l'id du user ($_SESSION)
$idAccount = $_SESSION['auth']['id'];

//Quand la personne n'a pas encore voté et qu'elle veut mettre un vote positif
if (!empty($_POST['up'])) {
    // UPDATE VERS BDD avec opinion = 1
      $opinion = 1;
    try {
      insertVotes($idAccount, $idActeur, $opinion);

      $_SESSION['msg'] = "Votre vote positif a ete pris en compte";
    }

    catch (Exception $e)
    {

            $_SESSION['msg'] = "Vous avez deja vote";
    }


}


//Quand la personne n'a pas encore voté et qu'elle veut mettre un vote négatif
if (!empty($_POST['down'])) {
    // UPDATE VERS BDD avec opinion = 0
    $opinion = 0;
    try {
      insertVotes($idAccount, $idActeur, $opinion);

      $_SESSION['msg'] = "Votre vote negatif a ete pris en compte";
    }

    catch (Exception $e)
    {

            $_SESSION['msg'] = "Vous avez deja vote";
    }
}

//Ajouter un commentaire
if (!empty($_POST['comment'])) {
    if (empty($_POST['comments']))  {
        $msgError['content'] = "Vous avez oublie de rentrer votre commentaire";
        $error++;
    } elseif (strlen($_POST['comments']) > 45) {
        $msgError['content'] = "Le commentaire est trop long (45 caractères max)";
        $error++;
    }

    if ($error === 0) {
        $date = new Datetime();
        $dateaenvoyer = $date->format('y-m-d H:i:s');

        insertComment($dateaenvoyer, $_POST['comments'], $_SESSION['auth']['id'], $actor["id"]);

        $_SESSION['msg'] = "Votre commentaire a bien été ajouté";
    }
}

$resultat = getResultat();
$totalComments = getTotalComments();

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
	<meta charset="utf-8">
	<title>GBAF - Détail Acteurs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/tablett.css" media="screen and (min-width: 425px)">
	<link rel="stylesheet" type="text/css" href="css/desktop.css" media="screen and (min-width: 769px)">
	<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="style.css">
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
       <p><input type="submit" name="profile" value="Changer mes paramètres de profil"/></p>
    </form>
		<div class="content-header">
			<div>
      <a href="/acteurs.php"> <img src="images/GBAF.png" alt="Logo"></a>
			</div>
			<div class="content-user">
				<img class="img-user" src="images/user.png" alt="utilisateur">
				<p>
          <?=$_SESSION['auth']['lastname']?> <?=$_SESSION['auth']['firstname']?>
        </p>
			</div>
		</div>
	</section>
    </header>

	<!-- parties logo et contenu -->
	<!-- SECTION CONTENU -->
	<section id="contenu">

		<p><img class="logo-acteur1" src="images/<?= $actor["filename"]?>"  alt="Logo du partenaire <?=$actor["title"]?>"></p>

		<h2 class="title-page">Pr&eacutesentation</h2>


		<div class="contenu-textuel">

			<p>

        <?= $actor["description"]?>
      </p>
		</div>

	</section>

	<section id="commentaires">
    <div class="content-buttons">

  <!-- ajouter un if -->
  <div class="totalvotes">
  <!-- Selectionner le nombre de likes-->
      <p>Nombre de J'aime : 1  </p>
      <p> Nombre de Je n'aime pas : 0 </p>


  </div>
  <?php if (!$votes) : ?>
      <form method="post">
    <div class="boutons">
    <input type="submit" name="up" value="J'aime">
  </form>
  <form method="post">
    <input type="submit" name="down" value="Je n'aime pas">
  </div>
  </form>

<?php else : ?>
    <p>Vous avez déjà voté</p>.
<?php endif; ?>

    </div>

    <p><?= $totalComments?> Commentaires</p>
		<form method="post">

			<p>
        <label for="comments">Nouveau commentaire : </label>

        <input type="input" name="comments" id="comments" value="<?= (!empty($_POST['comments']) AND !empty($msgError['content'])) ? $_POST['comments'] : '' ?>"/>
        <span class="<?= !empty($msgError['content']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['content']) ? $msgError['content'] : '' ?></span>
      </p>
			<p><input type="submit" name="comment" value="Publier"/></p>

    </form>

	</section>

 <div class="content-comments">

   <div class="">
    <?php foreach ($resultat as $value): ?>
      <div class="comment">
        <?php
            $date = new DateTime($value["created_at"]);
            $date->setTimezone(new DateTimeZone('Europe/Paris'));
        ?>
     <p>Prenom : <?= ucfirst($value["username"]) ?></p>
     <p>Date :  <?= 'Le ' . $date->format('d-m-y') . ' à ' . $date->format('H:i:s') ?> </p>
     <p>Commentaire : <?= ucfirst($value["content"]) ?></p>
     </div>
    <?php endforeach; ?>
   </div>
 </div>


	<!-- SECTION FOOTER -->
  <footer id="footer">
    <a href="copyright.php" title="Mentions légales / Contact"> Mentions légales / Contact </a>
  </footer>

</body>

</html>