<?php
include "fonction.inc.php";
session_start();

// Connexion à la base de données
$dbh = connexion();

$message = "";
// Récupère le contenu du formulaire
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$ligue = isset($_POST['ligue']) ? $_POST['ligue'] : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);
$_hash = password_hash($mdp, PASSWORD_DEFAULT);

// Ajoute le user
if ($submit) {
    if ($pseudo == !null && $mdp == !null && $mail == !null) {
        $sql = "insert into user(pseudo,mdp,mail,idusertype,idligue) values (:pseudo,:mdp,:mail,:idusertype,:idligue)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(
                array(
                    ':pseudo' => $pseudo,
                    ':mdp' => $_hash,
                    ':mail' => $mail,
                    ':idusertype' => 1,
                    ':idligue' => $ligue

                )
            );
        } catch (PDOException $ex) {
            die("Erreur lors de la requête SQL : " . $ex->getMessage());
        }
    } else {
        $message = "veuillez remplir tous les champs";
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
            <li><a href="login.php">Se connecter</a></li>
        </ul>
    </nav>

    <br>

    <div class="bigcontainer">
        <div class="container">
            <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="cont">
                    <h1 id="inscription">Inscription</h1>

                    <label for="pseudo">Pseudo</label> <br>
                    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo"> <br>

                    <label for="mdp">Mot de passe</label> <br>
                    <input type="password" id="mdp" name="mdp" placeholder="******"> <br>

                    <label for="email">E-mail</label> <br>
                    <input type="email" id="e-mail" name="mail" placeholder="abc@exemple.com"> <br>


                    <h3 id="ligue"> choisissez une ligue</h3>
                    <select name="ligue">
                        <option selected="yes" value="1">Football</option>
                        <option value="3">Volley</option>
                        <option value="2">Basket-ball</option>
                        <option value="4">Toutes les ligues</option>

                    </select><br><br>
                    <div class="but-general">
                        <input type="submit" name="submit" value="Connexion" />
                        <input type="submit" name="annuler" value="Annuler">
                    </div>
                    <?php
                    echo $message = "*Veuillez remplir tous les champs";
                    ?>
                </div>
        </div>
        </form>
    </div>
    </div>

</body>

</html>