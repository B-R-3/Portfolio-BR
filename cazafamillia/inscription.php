<?php
include "fonction.inc.php";
session_start();

// connexion à la base de données
$dbh = connexion();



$message = "";
// Récupère le contenu du formulaire
$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$mot_de_passe = isset($_POST['mot_de_passe']) ? trim($_POST['mot_de_passe']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

if ($submit) {
    // Vérification que tous les champs sont remplis
    if (!empty($login) && !empty($mot_de_passe) && !empty($email)) {
        // Hachage du mot de passe
        $_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $sql = "INSERT INTO _user (login, mot_de_passe, email) VALUES (:login, :mot_de_passe, :email)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute([
                ':login' => $login,
                ':mot_de_passe' => $_hash,
                ':email' => $email,
            ]);
            header("Location: index.php"); // Redirige après l'inscription
            exit();
        } catch (PDOException $ex) {
            die("Erreur lors de la requête SQL : " . $ex->getMessage());
        }
    } else {
        $message = "Veuillez remplir tous les champs";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <title>Inscription</title>
</head>

<body>
    <div class="bigcontainer">
        <div class="container">

            <form method="POST">
                <h1>Inscription</h1>
                <label for="login"></label><br>
                <input type="text" id="login" name="login" placeholder="Identifiant"/><br>


                <label for="mot_de_passe"></label><br>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required /><br>

                <label for="email"></label><br>
                <input type="text" id="email" name="email"  placeholder="ex@test.com" required /><br><br>

                <input type="submit" name="submit" value="Valider" class="wave-button"><br><br>

                <a href="connexion.php">
                    <p>J'ai déja un compte</p>
                </a>

        </div>
    </div>
</body>

</html>