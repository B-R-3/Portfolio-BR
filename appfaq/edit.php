<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}


include 'fonction.inc.php';
// Connexion à la base
$dbh = connexion();


// Récupère l'ID passé dans l'URL 
$id_faq = isset($_GET['id_faq']) ? $_GET['id_faq'] : '';


// Lecture du formulaire
$question = isset($_POST['question']) ? $_POST['question'] : ''; // obligatoire
$reponse = isset($_POST['reponse']) ? $_POST['reponse'] : ''; // obligatoire
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

if ($submit) {
  // Modification dans la base
  $sql = "UPDATE faq SET question=:question, reponse=:reponse, datereponse=current_timestamp() WHERE idfaq=:idfaq";
  try {
    $sth = $dbh->prepare($sql);
    $sth->execute(
      array(
        ":idfaq" => $id_faq,
        ":question" => $question,
        ":reponse" => $reponse,
      )
    );
    $nb = $sth->rowcount();
  } catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
  }
  $message = "$nb ligne(s) modifiée(s)";
  header("Location: list.php");
}
if ($annuler) {
  header("Location: list.php");
}


// Affichage de l'enregistrement courant dans le formulaire
$sql = "SELECT * FROM faq WHERE idfaq=:idfaq";

try {
  $sth = $dbh->prepare($sql);
  $sth->execute(
    array(
      ":idfaq" => $id_faq
    )
  );
  $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}
/*
  $id_faq = $row['idfaq'];
  $question  = $row['question'];
  $reponse  = $row['reponse'];
  $message = "Veuillez modifier la station SVP";
*/

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
      <h1><a href="list.php">AppFAQ/(admin)</a> </h1>
    </div>
    <ul>
      <li><a href="deco.php">Déconnexion</a></li>
    </ul>
  </nav>
  <h1>Page de Modification</h1>

  <div class="question-table-edit">
    <div class="header">Question</div>
    <div class="header">Réponse</div>


    <?php
    // Affiche les données récupérées dans la table
    foreach ($rows as $row) {
      echo '<div class="data">' . $row["question"] . '</div>';
      echo '<div class="data">' . $row["reponse"] . '</div>';
    }

    ?>




    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_faq=" . $id_faq; ?>" method="post">
      <label for="question">Modifier la question</label> <br> <br>
      <textarea name="question" id="question" cols="30" rows="10"><?php echo $row['question']; ?></textarea><br>

      <label for="reponse">Modifier la réponse</label> <br> <br>
      <textarea name="reponse" id="reponse" cols="30" rows="10"><?php echo $row['reponse']; ?></textarea>
  </div>



  <div class="but-general edit">
    <input type="submit" name="submit" value="Modifier" />
    <input type="submit" name="annuler" value="Annuler">
  </div>



</body>

</html>