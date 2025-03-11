<?php
include "fonction.inc.php";
session_start();

// Connexion à la base de données
$dbh = connexion();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

// Vérification du formulaire soumis
if (isset($_POST['submit'])) {
    header("Location: confirmation.php");
    exit();
}

// Vérifier l'ID de commande, utiliser 1 par défaut si absent (pour tester)
$id_commande = isset($_GET["id_commande"]) ? $_GET["id_commande"] : '';
$login = $_SESSION['login']; // Login de l'utilisateur

// Récupérer l'utilisateur depuis le login
$sql_user = 'SELECT id_user, login FROM _user WHERE login = :login';
try {
    $sth = $dbh->prepare($sql_user);
    $sth->execute([':login' => $login]);
    $user = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Aucun utilisateur trouvé avec ce login.");
    }
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL pour _user : " . $ex->getMessage());
}

// Récupérer le total de la commande
$sql_commande = 'SELECT total_commande FROM commande WHERE id_commande = :id_commande';
try {
    $sth = $dbh->prepare($sql_commande);
    $sth->execute([':id_commande' => $id_commande]);
    $commande = $sth->fetch(PDO::FETCH_ASSOC);

    if ($commande) {
        $total_commande = $commande['total_commande'];
    } else {
        die("Erreur : Commande introuvable avec l'ID $id_commande.");
    }
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL pour commande : " . $ex->getMessage());
}
if (isset($_POST['submit'])){
    header("Location: confirmation.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de démonstration de paiement par Craftyx">
    <meta name="author" content="Craftyx">
    <title>Page de démonstration de paiement par Craftyx</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <p>Voici la commande de <strong><?php echo htmlspecialchars($login); ?></strong></p>
    <div class="container">
        <div class='row'>
            <div class='col-md-4 col-md-offset-4'>
                <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class='form-row'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Nom sur la carte</label>
                            <input class='form-control' size='4' type='text' name="name">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-12 form-group card'>
                            <label class='control-label'>Numéro de carte</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-4 form-group cvc'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvc">
                        </div>
                        <div class='col-xs-4 form-group expiration'>
                            <label class='control-label'>Expiration</label>
                            <input class='form-control card-expiry-month' placeholder='MM/AAAA' size='7' type='text' name="expiration_month">
                        </div>
                        <!-- <div class='col-xs-4 form-group expiration'>
                            <label class='control-label'>Année </label>
                            <input class='form-control card-expiry-year' placeholder='AAAA' size='4' type='text' name="expiration_year">
                        </div> -->
                    </div>

                    <div class='form-row'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Prix à payer: <?php echo number_format($total_commande, 2, ',', ' '); ?> €</label>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='col-md-12 form-group'>
                            <a href="confirmation.php"><input class='form-control btn btn-primary submit-button' type='submit' name="submit">Payer »</input></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>