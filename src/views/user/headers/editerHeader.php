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
                <a href="./index.php?action=filteredRecipesCategory">Filtrer...</a>
                <ul>
                    <li><a href="./index.php?action=filteredRecipesCategory">Par catégorie</a></li>
                    <li><a href="./index.php?action=filteredRecipesTitle">Par titre</a></li>
                    <li><a href="./index.php?action=filteredRecipesIngredient">Par ingrédient</a></li>
                </ul>
            </li>
            <li>
                <a href="./index.php?action=myRecipes">Mes Recettes</a>
            </li>
            <li>
                <a href="./index.php?action=userDetails&id=<?= $_SESSION['id'] ?>">Mon compte</a>
                <ul>
                <li><a href="./index.php?action=updateUser&id=<?= $_SESSION['id'] ?>">Modifier mon compte</a></li>
                    <li><a href="./index.php?action=logout">Se déconnecter</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>