<?php
include "fonction.inc.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Connexion à la base de données
$dbh = connexion();

$message = "";

// Récupère l'ID passé dans l'URL 
$id_faq = isset($_GET['id_faq']) ? $_GET['id_faq'] : '';


// Récupère le contenu du formulaire
$reponse = isset($_POST['reponse']) ? $_POST['reponse'] : '';
$question = isset($_POST['question']) ? $_POST['question'] : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

$sql = "select * from faq where idfaq=:idfaq";
try {
    $sth = $dbh->prepare($sql);
    $sth->execute(array(':idfaq' => $id_faq));
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}


// Vérifie le user


if ($submit) {
    $sql = "delete from faq where  idfaq=:idfaq";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':idfaq' => $id_faq
        ));
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
    header("Location: list.php");
}
if ($annuler) {
    header("Location: list.php");
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Supprimer</title>
</head>

<body>
    <nav>
        <div class="logo">
            <h1><a href="list.php">AppFAQ (admin)</a> </h1>
        </div>
        <ul>
            <li><a href="deco.php">Déconnexion</a></li>
        </ul>
    </nav>

    <br>
    <h1 id="list">Supression de message</h1>

    <div class="question-table2">
        <div class="header">Question</div>
        <div class="header">Réponse</div>
        <div class="header">Date Reponse</div>
        <div class="header">Date question</div>

        <?php
        // Affiche les données récupérées dans la table
        foreach ($rows as $row) {
            echo '<div class="data">' . $row["question"] . '</div>';
            echo '<div class="data">' . $row["reponse"] . '</div>';
            echo '<div class="data">' . $row["datequestion"] . '</div>';
            echo '<div class="data">' . $row["datereponse"] . '</div>';
        }


        ?>



    </div>
    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_faq=" . $id_faq; ?>" method="post">
        <div class="but-general">
            <input type="submit" name="submit" value="Supprimer" />
            <input type="submit" name="annuler" value="Annuler">
        </div>
    </form>


</body>

</html>