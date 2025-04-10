<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>CazaFamilia - Restaurant Italien Authentique</title>
</head>
<body>
    <?php
    include "fonction/fonction-db.php";
    include "fonction/fonction.inc.php";
    session_start();
    ?>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="restaurant-name">CazaFamilia</h1>
                <p>Une expérience culinaire italienne authentique</p>
                <a href="pages/menu.php" class="button">
                    <span class="button-content">Découvrir notre menu</span>
                </a>
            </div>
        </section>

        <section class="presentation-section">
            <div class="presentation-content">
                <h2 class="presentation-title">Bienvenue chez CazaFamilia</h2>
                <p class="presentation-text">
                    Au cœur de la tradition culinaire italienne, CazaFamilia vous invite à découvrir une expérience gastronomique unique. Notre restaurant familial perpétue les recettes ancestrales transmises de génération en génération, en utilisant uniquement les meilleurs ingrédients importés directement d'Italie.
                </p>

                <div class="features">
                    <div class="feature">
                        <h3 class="feature-title">Cuisine Authentique</h3>
                        <p class="feature-text">Des recettes traditionnelles préparées avec passion par nos chefs italiens expérimentés.</p>
                    </div>
                    <div class="feature">
                        <h3 class="feature-title">Ingrédients de Qualité</h3>
                        <p class="feature-text">Des produits frais et authentiques sélectionnés avec soin pour vous offrir le meilleur de l'Italie.</p>
                    </div>
                    <div class="feature">
                        <h3 class="feature-title">Ambiance Chaleureuse</h3>
                        <p class="feature-text">Une atmosphère familiale et conviviale pour des moments inoubliables en famille ou entre amis.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>