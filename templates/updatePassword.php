<?php $title = "Inscription"; ?>

<?php ob_start(); ?>

<div class="form-container container">
    <h1>S'inscrire</h1>

    <?php if($error !== "") : ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form action="./index.php?action=updatePasswordPost" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="password">Mot de passe actuel : </label></td>
                    <td><input type="password" name="password" id="password" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="newpassword">Nouveau mot de passe : </label></td>
                    <td><input type="password" name="newpassword" id="newpassword" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="newpassword2">Email : </label></td>
                    <td><input type="password" name="newpassword2" id="newpassword2" maxlength="32" required> </td>
                </tr>
                <td><input type="hidden" name="email" id="email" maxlength="32" value="<?php $user->use_email ?>"> </td>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Modifier mon mot de passe&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>