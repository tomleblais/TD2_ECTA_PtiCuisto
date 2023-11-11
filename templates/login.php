<?php $title = "connection"; ?>

<?php ob_start(); ?>

<div class="form-container container">
    <h1>Connexion</h1>

    <?php if($error !== "") : ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form action="./index.php?action=loginPost" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="email">Email :</label></td>
                    <td><input type="email" name="email" id="email" maxlength="128" required></td>
                </tr>
                <tr>
                    <td><label for="password" class="password">Mot de passe :</label></td>
                    <td><input type="password" name="password" id="password" maxlength="128" required></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Je me connecte&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
    <p>
        J'ai n'ai pas encore de compte ? Cliquez <a href="./index.php?action=signin">ici</a>.
    </p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>