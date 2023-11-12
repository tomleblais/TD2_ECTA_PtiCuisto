<?php $title = "Inscription"; ?>

<?php ob_start(); ?>

<div class="form-container container">
    <h1>S'inscrire</h1>

    <?php if($error !== "") : ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form action="./index.php?action=signinPost" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="nickname">Nom d'utilisateur :</label></td>
                    <td><input type="text" name="nickname" id="nickname"  maxlength="32" required></td>
                </tr>
                <tr>
                    <td><label for="firstname">Prénom :</label></td>
                    <td><input type="text" name="firstname" id="firstname" maxlength="32" required></td>
                </tr>
                <tr>
                    <td><label for="lastname">Nom :</label></td>
                    <td><input type="text" name="lastname" id="lastname" maxlength="32" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email :</label></td>
                    <td><input type="email" name="email" id="email" maxlength="32" required></td>
                </tr>
                <tr>
                    <td><label for="password" class="password">Mot de passe :</label></td>
                    <td><input type="password" name="password" id="password" maxlength="128" required></td>
                </tr>
                <tr>
                    <td><label for="password2" class="password">Confirmation du mot de passe :</label></td>
                    <td><input type="password" name="password2" id="password2" maxlength="128" required></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Je m'inscris&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
    <p>
        J'ai déja un compte ? Cliquez <a href="./index.php?action=login">ici</a>.
    </p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./src/views/layout.php') ?>