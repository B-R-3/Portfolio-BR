<?php
session_start();
session_unset(); // Détruit toutes les variables de session
session_destroy(); // Détruit la session (mais pas le cookie)
setcookie(session_name(),'',-1,'/'); // Détruit le cookie de session
header("Location: index.php");
exit();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1> vous venez de vous déconnecter </h1>
    <a href="index.php">
        <h3>Revenir à la page d'acceuil</h3>
    </a>

</body>

</html>