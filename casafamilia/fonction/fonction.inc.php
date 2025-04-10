<?php
function verifUtilisateurConnecte()
{
    // Démarre la session si elle n'a pas encore été démarrée
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['user']['id_user'])) {
        // Redirige vers la page de connexion si non connecté
        header("Location: index.php");
        exit(); // Assure-toi que le script s'arrête après la redirection
    }
}


function deconnexion()
{
    //$dbh = NULL;
    unset($dbh);
}
?>


<!-- /*-------nav-bar--------*/ -->
<?php
// Récupération de la page courante
$current_page = basename($_SERVER['PHP_SELF']);
$is_index = strpos($_SERVER['PHP_SELF'], 'index.php') !== false;

// Fonction pour générer la navigation dynamiquement
function afficherNav($liens, $is_index)
{
    echo '<nav class="navbar">';
    echo '    <div class="navbar-brand">';
    if ($is_index) {
        echo '        <a href="index.php">CazaFamilia</a>';
    } else {
        echo '        <a href="../index.php">CazaFamilia</a>';
    }
    echo '    </div>';
    echo '    <ul class="navbar-nav">';
    foreach ($liens as $texte => $url) {
        if ($is_index) {
            if ($url === 'index.php') {
                echo "<li><a href=\"$url\" class=\"nav-link\">$texte</a></li>";
            } else {
                echo "<li><a href=\"pages/$url\" class=\"nav-link\">$texte</a></li>";
            }
        } else {
            if ($url === 'index.php') {
                echo "<li><a href=\"../$url\" class=\"nav-link\">$texte</a></li>";
            } else {
                echo "<li><a href=\"$url\" class=\"nav-link\">$texte</a></li>";
            }
        }
    }
    echo '    </ul>';
    echo '</nav>';
}

// Définir les liens de navigation en fonction de la page courante
switch ($current_page) {
    case 'index.php':
        $liens = [
            'Menu' => 'menu.php',
            'Connexion' => 'connexion.php',
            'Inscription' => 'inscription.php'
        ];
        break;
    case 'menu.php':
        $liens = [
            'Retour' => 'index.php',
            'Connexion' => 'connexion.php',
            'Inscription' => 'inscription.php'
        ];
        break;

    case 'connexion.php':
        $liens = [
            'Inscription' => 'inscription.php'
        ];
        break;

    case 'inscription.php':
        $liens = [
            'Connexion' => 'connexion.php'
        ];
        break;
    default:
        $liens = [
            'Déconnexion' => 'deconnexion.php'
        ];
        break;
}

// Affichage du menu
afficherNav($liens, $is_index);
?>

<!-- police d'écriture italienne -->

<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Italianno&display=swap');
    </style>
</body>
