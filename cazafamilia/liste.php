<?php
include "fonction.inc.php";
session_start();


// connexion à la base de données
$dbh = connexion();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

$type_conso = isset($_POST["type_conso"]) ? $_POST["type_conso"] : '';
$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : '';
$qte = isset($_POST['qte']) ? $_POST['qte'] : array(); // Capture les quantités

$sql = 'SELECT * FROM produit';
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}

if (isset($_POST['submit'])) {
    // Vérification de l'existence de l'id_user dans la session
    if (!isset($_SESSION['id_user'])) {
        die('Utilisateur non authentifié.');
    }

    $id_user = $_SESSION['id_user']; // Récupération de l'ID utilisateur depuis la session

    // Insertion dans la table commande
    $sql = "INSERT INTO commande(type_conso, _date, id_user) VALUES (:type_conso, CURRENT_TIMESTAMP(), :id_user)";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(
            array(
                ":type_conso" => $type_conso,
                ":id_user" => $id_user // Ajout de l'id_user à la requête
            )
        );

        // récupérer l'ID de la dernière ligne insérée dans une table de la base de données.
        $id_commande = $dbh->lastInsertId();

        // Insertion dans la table lignecommande pour chaque produit commandé
        $sql1 = "INSERT INTO lignecommande(qte, id_produit, id_commande) VALUES (:qte, :id_produit, :id_commande)";
        $sth = $dbh->prepare($sql1);

        foreach ($qte as $id_produit => $qte) {
            if ($qte > 0) { // Si la quantité est supérieure à 0
                $sth->execute(
                    array(
                        ":qte" => $qte,
                        ":id_produit" => $id_produit,
                        ":id_commande" => $id_commande
                    )
                );
            }
        }

        // Rediriger après insertion
        // Récuêration de l'id_commande et type conso pour la page validation.php
        header("Location: validation.php?id_commande=" . $id_commande . "&type_conso=" . $type_conso);
        exit();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
}


if (isset($_POST['annuler'])) {
    header("Location: index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>liste des produits</title>
</head>

<body>


    <div class="bigcontainer qte">
        <div class="suite">
            <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <h1>Liste des produits disponibles</h1>
                <div class="liste">
                    <table>
                        <tr>
                            <th>Plat</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>

                        <?php
                        // tableau de tous les produits avec un choix de qté 
                        foreach ($rows as $row) {
                            echo '<tr><td>' . htmlspecialchars($row["libelle"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["prix_ht"]) . '€</td>';
                            echo '<td><input type="number" name="qte[' . $row["id_produit"] . ']" min="0" max="20" placeholder="0"></td></tr>';
                        }
                        ?>
                    </table>
                </div>

                <!-- Boutons radio pour le type de consommation -->
                <p>
                    <input type="radio" name="type_conso" value="1" required> À emporter
                    <input type="radio" name="type_conso" value="0" required> Sur place
                </p>

                <!-- Boutons de soumission -->
                <div class="conso">
                    <input type="submit" name="submit" value="Valider" class="wave-button">
                    <input type="submit" name="annuler" value="Annuler" class="wave-button">
                    <!-- <input type="hidden" name="form_submitted" value="1"> -->
                </div>
            </form>

        </div>
    </div>

</body>

</html>
