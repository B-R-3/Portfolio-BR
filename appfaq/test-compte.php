<?php
include "fonction.inc.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$dbh = connexion();

$message = "";
$iduser = $_SESSION['user']['iduser'];
echo $iduser;
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$idligue = isset($_POST['idligue']) ? $_POST['idligue'] : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);
$_hash = password_hash($mdp, PASSWORD_DEFAULT);

$sql1 = 'select * from user where  mail =:mail';
try {
    $sth = $dbh->prepare($sql1);
    $sth->execute(array(
        ":mail" => $mail,

    ));
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}
// Vérifie le user
if ($submit) {
    $sql = "UPDATE user SET mdp=:mdp, mail=:mail, idligue=:idligue  WHERE iduser=:iduser";
    echo  $iduser;
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(
            array(
                ':mail' => $mail,
                ':mdp' => $_hash,
                ':idligue' => $idligue,
                ':iduser' => $iduser
            )
        );
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
    if (count($rows) == 1 && password_verify($mdp, $rows[0]["mdp"])) {
        $_SESSION['user'] = $rows[0];
        header("Location: list.php");
        exit();
    } else {
        $message = "pseudo et/ou mdp invalide";
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
            <h1><a href="index.php">AppFAQ</a></h1>
        </div>
        <ul>
            <li><a href="deco.php">Déconnexion</a></li>
        </ul>
    </nav>


    <br>
    <div class="bigcontainer">


        <div class="container">
            <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="cont">
                    <h1>Récapitulatif du compte</h1>

                    <label for="pseudo">Mot de passe</label> <br>
                    <input type="text" id="mdp" name="mdp" placeholder="veuillez saisir votre MDP" required><br>

                    <label for="mail">Email</label> <br>
                    <input type="text" id="mail" name="mail" value=<?php echo  $_SESSION['user']['mail']; ?>>
                    <br>

                    <label for="idligue">Choisissez une idligue :</label><br>
                    <select id="idligue" name="idligue" required>
                        <option value="1" <?php echo ($_SESSION['user']['idligue'] == 1) ? 'selected' : ''; ?>>Football</option>
                        <option value="2" <?php echo ($_SESSION['user']['idligue'] == 2) ? 'selected' : ''; ?>>Basket-ball</option>
                        <option value="3" <?php echo ($_SESSION['user']['idligue'] == 3) ? 'selected' : ''; ?>>Volley</option>
                        <option value="4" <?php echo ($_SESSION['user']['idligue'] == 4) ? 'selected' : ''; ?>>Handball</option>
                    </select><br>

                    <input type="submit" name="submit" value="Enregistrer">
                      
                </div>
        </div>
        </form>

        <p></p>

</body>

</html>