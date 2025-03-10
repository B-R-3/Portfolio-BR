<?php

include "fonction.inc.php";
session_start();


// connexion à la base de données
$dbh = connexion();
$id_commande = isset($_GET["id_commande"]) ? $_GET["id_commande"] : '';

$sql = "update commande set id_etat = :id_etat where id_commande = :id_commande";
try {
    $sth = $dbh->prepare($sql);
    $sth->execute(
        array(
            ":id_commande" => $id_commande,
            ":id_etat" => 1,
        )
    );
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
}

?>