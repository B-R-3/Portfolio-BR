<?php
include "../fonction/fonction-db.php";
include "../fonction/fonction.inc.php";
session_start();

// Connexion à la base de données
$dbh = connexion();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

// Vérification du formulaire soumis
if (isset($_POST['submit'])) {
    header("Location: ../pages/confirmation.php");
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
    header("Location: ../pages/confirmation.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de démonstration de paiement par Craftyx">
    <meta name="author" content="Craftyx">
    <link rel="stylesheet" href="../style/payement.css">
    <title>Paiement sécurisé</title>
</head>

<body>
    <div class="bigcontainer">
        <div class="suite">
            <div class="payment-methods">
                <button class="payment-button apple-pay">
                    <img src="../assets/apple-pay.svg" alt="Apple Pay" height="24">
                </button>
                <button class="payment-button google-pay">
                    <img src="../assets/google-pay.svg" alt="Google Pay" height="24">
                </button>
            </div>

            <div class="divider">
                <span>Ou payez par carte</span>
            </div>

            <div class="card-section">
                <div class="card-header">
                    <div class="card-icons">
                        <img src="../assets/visa.svg" alt="Visa" height="24">
                        <img src="../assets/mastercard.svg" alt="Mastercard" height="24">
                        <img src="../assets/amex.svg" alt="American Express" height="24">
                    </div>
                </div>

                <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label class="control-label">Nom sur la carte</label>
                        <input type="text" class="form-control" name="name" >
                    </div>

                    <div class="form-group">
                        <label class="control-label">Numéro de carte</label>
                        <input type="text" class="form-control" name="card_no" >
                    </div>

                    <div class="card-details">
                        <div class="form-group">
                            <label class="control-label">Date d'expiration</label>
                            <input type="text" class="form-control" name="expiration_month" placeholder="MM/AA" >
                        </div>

                        <div class="form-group">
                            <label class="control-label">Code de sécurité</label>
                            <input type="text" class="form-control" name="cvc" placeholder="CVC" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="price-display">
                            Total à payer : <?php echo number_format($total_commande, 2, ',', ' '); ?> €
                        </div>
                    </div>

                    <button type="submit" name="submit" class="submit-button">
                        Payer <?php echo number_format($total_commande, 2, ',', ' '); ?> €
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>