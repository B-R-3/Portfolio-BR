<?php
function connexion()
{
    $dsn = 'mysql:host=localhost;dbname=u305901407_cazafamilia';
    $user = 'u305901407_br';
    $password = 'SoV5UD|d$J5';
    try {
        $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND =>
        "SET NAMES utf8"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
         die("Erreur lors de la connexion SQL : " . $ex->getMessage());
    }
    return $dbh;
}

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

// Fonction pour générer la navigation dynamiquement
function afficherNav($liens)
{
    echo "<nav>";
    echo '  <div class="logo">';
    echo '  <a href="index.php"><h1>CazaFamilia</h1></a>';
    echo '  </div>';
    echo '  <ul>';
    foreach ($liens as $texte => $url) {
        echo "    <li><a href=\"$url\">$texte</a></li>";
    }
    echo '  </ul>';
    echo "</nav>";
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
afficherNav($liens);
?>

<!-- police d'écriture italienne -->

<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Italianno&display=swap');
    </style>
</body>
