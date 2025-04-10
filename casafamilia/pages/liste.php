<?php
include "../fonction/fonction-db.php";
include "../fonction/fonction.inc.php";
session_start();

// Message d'alerte pour la redirection
$error_message = '';
if(isset($_GET['error'])) {
    switch($_GET['error']) {
        case 'no_plat':
            $error_message = 'Veuillez sélectionner au moins un plat pour valider votre commande.';
            break;
        case 'no_conso':
            $error_message = 'Veuillez sélectionner un mode de consommation (sur place ou à emporter).';
            break;
    }
}

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

    // Vérifier si un mode de consommation est sélectionné
    if (!isset($_POST['type_conso'])) {
        header("Location: liste.php?error=no_conso");
        exit();
    }

    // Vérifier si au moins un plat est sélectionné
    $plat_selectionne = false;
    foreach ($qte as $quantite) {
        if ($quantite > 0) {
            $plat_selectionne = true;
            break;
        }
    }

    if (!$plat_selectionne) {
        header("Location: liste.php?error=no_plat");
        exit();
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
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/liste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <title>CazaFamilia - Commander</title>
</head>

<body>
    <?php if($error_message): ?>
    <div class="alert">
        <?php echo $error_message; ?>
    </div>
    <?php endif; ?>

    <div class="main-container">
        <div class="menu-container">
        <form id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h1 class="menu-title">Notre Menu</h1>
            <table class="menu-table" id="liste">
                <thead>
                    <tr>
                        <th>Plats</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['libelle']); ?></td>
                            <td><?php echo number_format($row['prix_ht'], 2); ?> €</td>
                            <td>
                                <div class="quantity-wrapper">
                                    <input type="number" 
                                        name="qte[<?php echo $row["id_produit"]; ?>]" 
                                        min="0" 
                                        max="20" 
                                        value="0"
                                        class="qte-input">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

                <div class="type-conso">
                    <h2 class="type-conso-title">Mode de Consommation</h2>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="type_conso" value="1" required>
                            <span class="radio-custom"></span>
                            <span class="radio-text">À emporter</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="type_conso" value="0" required>
                            <span class="radio-custom"></span>
                            <span class="radio-text">Sur place</span>
                        </label>
                    </div>
                </div>

                <div class="buttons-container">
                    <button type="submit" name="submit" class="liste-button submit-button">
                        <span class="button-text">Valider la commande</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>