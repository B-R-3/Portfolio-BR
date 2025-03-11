<?php
include "fonction.inc.php";
session_start();

$dbh = connexion();

$sql1 = 'select * from produit';
try {
    $sth = $dbh->prepare($sql1);
    $sth->execute(array());
    $rows = $sth->fetchALL(PDO::FETCH_ASSOC);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>Menu</title>
</head>
<div class="space"></div>
<body>
    <div class="suite">
        <h1>Notre carte</h1>
        <div class="liste">
            <table>
                <tr>
                    <th>Plats</th>
                    <th>Prix</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    echo "<tr><td>" . $row["libelle"] . "</td>";
                    echo "<td>" . $row["prix_ht"] . "€</td></tr>";;
                }
                ?>
        </div>
        </table>
    </div>

</body>

</html>