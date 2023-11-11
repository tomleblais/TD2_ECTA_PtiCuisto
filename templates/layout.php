<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Font imports -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        
        <!-- Style imports -->
        <link rel="stylesheet" href="./css/reset.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/layout.css">

        <title>PtiCuisto - <?= $title ?></title>
    </head>

    <body>
        <header>
            <nav>
                <ul>
                    <li>
                        <a href="./index.php">Accueil</a>
                    </li>
                    <li>
                        <a href="./index.php?action=allRecipes">Nos recettes</a>
                    </li>
                    <li>
                        <a href="./index.php?action=filteredRecipes">Filtrer...</a>
                        <ul>
                            <li><a href="">Par catégorie</a></li>
                            <li><a href="">Par titre</a></li>
                            <li><a href="">Par ingrédient</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="./index.php?action=login">Connexion</a>
                    </li>
                </ul>
            </nav>
        </header>

        <main>
            <?= $content ?>
        </main>
    </body>

    <footer>
        @ECTA Bon appetit !
    </footer>
</html>