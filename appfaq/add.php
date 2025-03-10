<?php

include 'fonction.inc.php';
// Connexion à la base
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}
$dbh = connexion();

// Lecture du formulaire
$question = isset($_POST['question']) ? $_POST['question'] : ''; // obligatoire
$iduser = isset($_SESSION['user']['iduser']) ? $_SESSION['user']['iduser'] : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

// Ajout dans la base
if ($submit) {
  if ($question == !null) {
    $sql = "INSERT INTO faq(question,iduser) VALUES (:question,:iduser) ";
    try {
      $sth = $dbh->prepare($sql);
      $sth->execute(array(
        ":question" => $question,
        ":iduser" => $iduser
      ));
      $nb = $sth->rowcount();
    } catch (PDOException $ex) {
      die("<p>Erreur lors de la requête SQL : " . $ex->getMessage() . "</p>");
    }
    header("Location: list.php");
  }
} else {
  $message = "Veuillez saisir une question";
}
if ($annuler) {
  header("Location: list.php");
}
// Affichage
?>



<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>AppFAQ</title>
</head>

<body>
  <nav>
    <div class="logo">
      <h1> <a href="list.php"> AppFAQ </a></h1>
    </div>
    <ul>
      <li><a href="deco.php">Déconnexion</a></li>

    </ul>
  </nav>

  <br>
  .
  <h1 id="list">Ajouter une question</h1>

  <div class="bigcontainer">
    <form id="formulaire" action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
      <label for="question"></label> <br>
      <input type="text" id="text" name="question" placeholder="Poser votre question"> <br>

      <div class="but-general">
        <input type="submit" name="submit" value="Soumettre" />
        <input type="submit" name="annuler" value="Annuler">

      </div>
    </form>

  </div>
  <br>



</body>

</html>