<?php

include "../fonction/fonction-db.php";
session_start();


// connexion à la base de données
$dbh = connexion();

$sql = "SELECT c.*,renvoie_somme_produit(id_commande) as total_nb_produit, u.login FROM commande c, _user u where c.id_user = u.id_user ";
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête SQL : " . $ex->getMessage());
} 

foreach ($rows as &$row) { // le & sert a pouvoir modifier le $row qui est en lecture seule
    $sql1 = "SELECT l.*, libelle FROM lignecommande l, produit u  WHERE l.id_produit = u.id_produit AND id_commande = :id_commande";
    try {
        $sth = $dbh->prepare($sql1);
        $sth->execute(
            [':id_commande' => $row['id_commande']]
        );
        $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de la requête SQL : " . $ex->getMessage());
    }
    $row['lignes'] = $lignes;
}

// Envoi du contenu au format JSON
$json = json_encode($rows,JSON_PRETTY_PRINT);
//file_put_contents("commandes.json",$json);
header("Content-type: application/json; charset=utf-8");
echo $json;
 // Renvoie à la page d'accueil car rien ne s'affiche dans le navigateur





?>