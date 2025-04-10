<?php
include "../fonction/fonction-db.php";
include "../fonction/fonction.inc.php";
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
            header("Location: ../pages/connexion.php"); // Redirige après l'inscription
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
    <link rel="stylesheet" href="../style/style.css">
    <title>CazaFamilia - Inscription</title>
</head>

<body>
    <div class="main-container">
        <div class="form-section">
            <div class="form-container">
                <h1 class="form-title">Inscription</h1>
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" name="login" placeholder="Identifiant" required class="form-input">
                    </div>
                    <div class="form-group">
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required class="form-input">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required class="form-input">
                    </div>
                    <button type="submit" name="submit" class="button form-submit">
                        <span class="button-content">S'inscrire</span>
                    </button>
                </form>
                <?php if (isset($error)): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
                <p class="form-footer">
                    Déjà inscrit ? <a href="connexion.php" class="form-link">Connectez-vous</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>