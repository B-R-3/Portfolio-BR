<?php
include "../fonction/fonction-db.php";
include "../fonction/fonction.inc.php";
session_start();


$dbh = connexion();

$sql = 'SELECT * FROM produit';
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la requête SQL : " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>CazaFamilia - Notre Menu</title>
</head>
<body>


    <div class="main-container">
        <div class="menu-container">
            <h1 class="menu-title">Notre Menu</h1>
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Plats</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['libelle']); ?></td>
                            <td><?php echo number_format($row['prix_ht'], 2); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            
                <div style="text-align: center; margin-top: 2rem;">
                    <a href="connexion.php" class="button">
                        <span class="button-content">Commander</span>
                    </a>
                </div>
        </div>
    </div>
</body>

</html>