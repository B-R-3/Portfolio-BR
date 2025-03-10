<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>AppFAQ</title>
</head>

<body>
    <nav>
        <div class="logo">
            <h1>AppFAQ</h1>
        </div>
        <ul>
            <li><a href="deco.php">Déconnexion</a></li>

        </ul>
    </nav>

    <br>
    <h1>M2L</h1>
    <form id="formulaire" action="contact.php">
        <label for="nom">Nom</label> <br>
        <input type="text" id="nom"> <br>


        <label for="nom">Prenom</label> <br>
        <input type="text" id="prenom"> <br>

        <label for="nom">Pseudo</label> <br>
        <input type="text" id="pseudo"> <br>


        <select name="ligue">
            <label for="nom">Ma ligue</label> <br>

            <option>ligue </option>
            <option selected="yes">Bucharest</option>
            <option>Madrid</option>

        </select>

    </form>

</body>

</html>