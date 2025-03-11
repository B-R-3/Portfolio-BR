<?php
include "fonction.inc.php";
session_start();
// connexion BDD
$dbh = connexion();
// selectionner toute la table produit
if (isset($_SESSION['id_user'])) {
    header("Location: Liste.php");
}

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
    <title>CazaFamilia</title>
</head>

<body>
    <div class="fond_accueil">
        <div class="titre">
            <h1>Benvenuto</h1>
        </div>
    </div>
    <div class="txt">
        <h1>Lorem Ipsum</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare commodo erat, id lacinia mauris rutrum et. Aenean eget lacus hendrerit justo semper accumsan molestie a nisl. Nunc accumsan sed tortor et lacinia. Maecenas ultricies auctor augue interdum placerat. Aliquam dictum mauris ipsum, at ultrices leo molestie iaculis. Fusce varius, turpis at placerat mattis, leo ante iaculis est, vitae fermentum nibh tellus id lorem. Ut posuere euismod mi, vel bibendum ipsum lobortis eleifend. Sed pharetra eleifend purus, eu fringilla velit.
            Duis id vehicula nisl. Aliquam vitae libero eu est ultrices interdum. Cras semper dolor vitae ultrices volutpat. Nam at gravida nibh. Phasellus vitae porttitor arcu, vitae elementum erat. Vestibulum eu laoreet quam. Aenean ac lectus sit amet massa lobortis congue sit amet sit amet dui. Ut ac congue turpis. Aliquam suscipit, lacus eget commodo efficitur, dui nisi varius mi, id elementum nunc orci vitae massa. Quisque a rhoncus risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque commodo, libero nec pellentesque efficitur, magna velit congue est, placerat lacinia turpis ipsum nec tortor. Donec massa felis, imperdiet ut ligula volutpat, faucibus tincidunt tellus.
            Integer sit amet velit dictum est fermentum consequat. Integer condimentum augue neque, in lacinia nibh accumsan ut. Praesent gravida sem felis, id hendrerit nisi fringilla ac. Duis in fermentum massa. In commodo vestibulum nunc in consequat. Nunc molestie in ligula ut suscipit. Donec facilisis velit arcu, eu tempus justo laoreet sed.
            Cras dictum lorem ut feugiat pulvinar. Morbi tristique velit at lorem tempor viverra. Mauris malesuada massa ut lacus aliquam pellentesque. Nullam laoreet volutpat orci, vitae consequat purus euismod nec. Cras egestas iaculis est, quis semper risus suscipit ut. Aliquam et sem enim. Ut neque nunc, scelerisque a nisl eu, tristique feugiat tortor. Pellentesque pulvinar purus non ultricies blandit. Quisque elementum ante turpis, non rutrum magna convallis ac. Fusce dignissim elit massa, a suscipit est congue ac. Vestibulum tincidunt neque et urna venenatis, sed suscipit quam bibendum. Donec ullamcorper molestie dolor, ut laoreet erat ultricies scelerisque. Aliquam pellentesque quam nulla, ut viverra enim eleifend non. In tempus eleifend nibh, ut ornare augue tincidunt interdum. Nam laoreet neque tincidunt justo venenatis, ac mattis augue imperdiet.
        </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare commodo erat, id lacinia mauris rutrum et. Aenean eget lacus hendrerit justo semper accumsan molestie a nisl. Nunc accumsan sed tortor et lacinia. Maecenas ultricies auctor augue interdum placerat. Aliquam dictum mauris ipsum, at ultrices leo molestie iaculis. Fusce varius, turpis at placerat mattis, leo ante iaculis est, vitae fermentum nibh tellus id lorem. Ut posuere euismod mi, vel bibendum ipsum lobortis eleifend. Sed pharetra eleifend purus, eu fringilla velit.

Duis id vehicula nisl. Aliquam vit.</p>
    </div>
</body>

</html>
