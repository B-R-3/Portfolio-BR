<?php
session_start();
session_unset(); // Détruit toutes les variables de session
session_destroy(); // Détruit la session (mais pas le cookie)
setcookie(session_name(),'',-1,'/'); // Détruit le cookie de session
header("Location: index.php"); // Revient à la page d'accueil
exit();
?>