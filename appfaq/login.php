<?php
include "fonction.inc.php";
session_start();

// Connexion à la base de données
$dbh = connexion();

$message = "";

// Récupère le contenu du formulaire
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

// Vérifie le user
if ($submit) {
    $sql = "select * from user where pseudo=:pseudo ";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(
            array(
                ':pseudo' => $pseudo,   
            )
        );
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
    if (count($rows) == 1 && password_verify($mdp,$rows[0]["mdp"])) { 
        $_SESSION['user'] = $rows[0];
        header("Location: list.php");
        exit();
    } else {
        $message = "pseudo et/ou mdp invalide";
    }
}

if ($annuler) {
    header("Location: index.php");
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
            <h1><a href="index.php">AppFAQ</a></h1>
        </div>
        <ul>
            <li><a href="register.php">S'inscrire</a></li>
        </ul>
    </nav>

    <br>
    <div class="bigcontainer">


        <div class="container">
            <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="cont">
                    <h1>Connexion</h1>
                    <label for="pseudo">Identifiant</label> <br>
                    <input type="text" id="pseudo" name="pseudo" placeholder="identifiant"> <br>


                    <label for="mdp">Mot de passe</label> <br>
                    <input type="password" id="mdp" name="mdp" placeholder="password"> <br><br><br>

                    <div class="but-general">
                        <input type="submit" name="submit" value="Connexion"/>
                        <input type="submit" name="annuler" value="Annuler">

                    </div>
                </div>
        </div>
        </form>

        <p></p>

</body>

</html>