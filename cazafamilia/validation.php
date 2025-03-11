<?php
session_start();
include "fonction.inc.php";

// connexion à la base de données
$dbh = connexion();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Initialisation des variables

$type_conso = isset($_GET["type_conso"]) ? $_GET["type_conso"] : '';
$id_commande = isset($_GET["id_commande"]) ? $_GET["id_commande"] : '';
$qte = isset($_POST['qte']) ? $_POST['qte'] : array(); // Capture les quantités
$produits_commande = array(); // Initialisation à un tableau vide
$total_commande = 0; // Initialisation à 0
$total_ligne_ht = 0;

// Récupérer les produits commandés de la base de données
// Exemple : SELECT produit, prix_ht FROM produits WHERE id_user = :id_user
// Simulation des produits (ceci doit être remplacé par votre logique réelle)
// Selectionner le nom le prix la quantité et l'identifiant de la commande en fonction du numero de commande
$sql = 'SELECT p.libelle, p.prix_ht, l.qte, c.total_commande FROM lignecommande AS l, produit AS p, commande AS c WHERE l.id_produit = p.id_produit AND l.id_commande = c.id_commande AND c.id_commande = :id_commande;';
try {
    $sth = $dbh->prepare($sql);
    $sth->execute(
        array(
            ":id_commande" => $id_commande
        )
    );
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Récapitulatif de la commande</title>
</head>

<body>
    <div class="bigcontainer">
        <div class="suite">
            <h1>Récapitulatif de la commande</h1>
            <!-- affichage du type (a emporter ou sur place) et la date de la commande -->
            <p>Date de la commande : <?php echo date("Y-m-d H:i"); ?></p>

            <?php
            $date = "Type de concommation";
            if ($type_conso == 1) {
                echo "<p>$date   à emporter</p>";
            } else
                echo "<p>$date  sur place</p>";


            ?>
            <div class="liste">

                <table border="1">
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire (HT)</th>
                        <th>Quantité</th>
                        <th>Total (HT)</th>
                    </tr>

                    <?php
                    $total_ttc = 0; // Initialisation du total TTC

                    foreach ($rows as $row) :
                        $prix_ttc = $row['total_commande']; // Prix TTC par produit
                        $total_ttc += $prix_ttc; // Addition au total TTC
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['libelle']); ?></td>
                            <td><?php echo number_format($row['prix_ht'], 2); ?> €</td>
                            <td><?php echo htmlspecialchars($row['qte']); ?></td>
                            <td><?php echo htmlspecialchars($row['prix_ht'] * $row['qte']); ?> € </td>

                        </tr>
                    <?php endforeach; ?>

                    <!-- Ligne du Total TTC -->
                    <tr>
                        <td colspan="3" style="text-align: left;"><strong>Total TTC :</strong></td>
                        <td><strong><?php echo number_format($prix_ttc, 2); ?> €</strong></td>
                    </tr>
                </table>



                <!-- Affichage du total de la commande avec les taxes -->
                <!-- récupération de l'id_commande pour la page payemet -->
                <!-- <p><a href="payement.php?id_commande=<?php echo $id_commande; ?>">Régler la commande</a></p> -->
            </div>
            <div class="conso">
                <a href="payement.php?id_commande=<?php echo htmlspecialchars($id_commande); ?>">
                    <input type="submit" name="submit" value="Payer" class="wave-button">
                </a>
            </div>
        </div>
    </div>
</body>

</html>