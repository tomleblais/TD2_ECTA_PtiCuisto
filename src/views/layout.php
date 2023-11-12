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
        <link rel="stylesheet" href="./assets/css/reset.css">
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="stylesheet" href="./assets/css/styleMobile.css">
        <link rel="stylesheet" href="./assets/css/layout.css">
        <link rel="stylesheet" href="./assets/css/layoutMobile.css">

        <title>PtiCuisto - <?= $title ?></title>
    </head>

    <body>
        <?php require_once($_SESSION['header']) ?>

        <main>
            <?= $content ?>
        </main>

        <footer>
            @ECTA Bon appetit !
        </footer>
    </body>
</html>