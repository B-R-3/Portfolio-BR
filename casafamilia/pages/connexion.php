<?php
include "../fonction/fonction-db.php";
include "../fonction/fonction.inc.php";
session_start();

// Connexion à la base de données

$dbh = connexion();


$message = "";

// Récupère le contenu du formulaire
$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$mot_de_passe = isset($_POST['mot_de_passe']) ? trim($_POST['mot_de_passe']) : '';
$submit = isset($_POST['submit']);
$annuler = isset($_POST['annuler']);

if ($submit) {
    // Vérification que les champs ne sont pas vides
    if (!empty($login) && !empty($mot_de_passe)) {
        $sql = "SELECT * FROM _user WHERE login = :login";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute([':login' => $login]);
            $user = $sth->fetch(PDO::FETCH_ASSOC); // Récupère l'utilisateur

            // Vérification de l'utilisateur et du mot de passe
            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                // Mot de passe correct, connexion réussie
                $_SESSION['id_user'] = $user['id_user']; // Stocke l'ID utilisateur dans la session
                $_SESSION['login'] = $user['login']; // Stocke le login dans la session
                header("Location: ../pages/liste.php"); // Redirige vers une autre page
                exit();
            // si mot de passe ou ogin inconnu dans la base
            } else {
                $message = "Login et/ou mot de passe invalide";
            }
        // si erreur dans le requete sql
        } catch (PDOException $ex) {
            die("Erreur lors de la requête SQL : " . $ex->getMessage());
        }
    // si la personne n'a pas remplie les deux champs
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>CazaFamilia - Connexion</title>
</head>

<body>
    <div class="main-container">
        <div class="form-section">
            <div class="form-container">
                <h1 class="form-title">Connexion</h1>
                <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <input type="text" id="login" name="login" placeholder="Identifiant" required class="form-input">
                    </div>
                    <div class="form-group">
                        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required class="form-input">
                    </div>
                    <button type="submit" name="submit" class="button form-submit">
                        <span class="button-content">Se connecter</span>
                    </button>
                </form>
                <?php if (isset($message)): ?>
                    <p class="error-message"><?php echo $message; ?></p>
                <?php endif; ?>
                <p class="form-footer">
                    Pas encore de compte ? <a href="inscription.php" class="form-link">Inscrivez-vous</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>