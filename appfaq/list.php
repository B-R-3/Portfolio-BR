<?php
include "fonction.inc.php";
session_start();

// Redirige vers la page de connexion si on n'est pas connecté
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}


// Connexion à la base de données
$dbh = connexion();

$idusertype = isset($_SESSION['user']['idusertype']) ? $_SESSION['user']['idusertype'] : '';
$idligue = isset($_SESSION['user']['idligue']) ? $_SESSION['user']['idligue'] : '';

$sql1 = 'select libligue from ligue where idligue =:idligue';
try {
    $sth = $dbh->prepare($sql1);
    $sth->execute(array(
        ":idligue" => $idligue
    ));
    $rowz = $sth->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}

if ($idusertype == 1 || $idusertype == 2) {
    $sql = "select idfaq,pseudo,question,reponse,datequestion, datereponse  from faq as F, user as U where F.iduser = U.iduser and idligue = :idligue;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ":idligue" => $idligue
        ));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
} else {
    // Liste des utilisateurs
    $sql = "select idfaq,pseudo,question,reponse,datequestion, datereponse  from faq as F, user as U where F.iduser = U.iduser";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
}
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
            <h1><a href="list.php">AppFAQ</a></h1>
        </div>

        <?php
        echo "<p class = 'name'> Bienvenue à " . $_SESSION['user']['pseudo'] . "</p>";
        ?>
        <ul>
            <li><a href="deco.php">Déconnexion</a></li>
            <li><a href="test-compte.php">Gérer le compte</a></li>

        </ul>
    </nav>

    <br>
    <?php
    if ($idusertype == 3) {
    ?> <h1 id="list"> Liste des messages de toute les ligues</h1><br>
    <?php
    } else { ?>
        <h1 id="list"> Liste des messages de la ligue <?php echo $rowz["libligue"] ?> </h1><br>
    <?php
    }

    ?>

    <?php if ($idusertype == 2 || $idusertype == 3) {
        echo '<div class="question-table">';
        echo '<div class="header">Auteur</div>';
        echo '<div class="header">Question</div>';
        echo '<div class="header">Réponse</div>';
        echo '<div class="header">Date question</div>';
        echo '<div class="header">Date Reponse</div>';
        echo "<div class='header'>Actions</div>";
    } else {
        echo '<div class="question-table3">';
        echo '<div class="header">Auteur</div>';
        echo '<div class="header">Question</div>';
        echo '<div class="header">Réponse</div>';
        echo '<div class="header">Date question</div>';
        echo '<div class="header">Date Reponse</div>';
    }



    // Affiche les données récupérées dans la table

    foreach ($rows as $row) {
        echo '<div class="data">' . $row["pseudo"] . '</div>';
        echo '<div class="data">' . $row["question"] . '</div>';
        echo '<div class="data">' . $row["reponse"] . '</div>';
        echo '<div class="data">' . $row["datequestion"] . '</div>';
        echo '<div class="data">' . $row["datereponse"] . '</div>';
        if ($idusertype == 2 || $idusertype == 3) {
            echo '<div class="data"> <a href="edit.php?id_faq=' . $row['idfaq'] . '">MODIFIER</a>  <a href="Sup.php?id_faq=' . $row['idfaq'] . '">SUPPRIMER</a></div>';
        }
    }



    ?>

    <div class="but-general add">
        <a href="add.php"><input type="button" id="v" value="Ajouter"> <br></a>

    </div>



    </select>

    </form>

</body>

</html>