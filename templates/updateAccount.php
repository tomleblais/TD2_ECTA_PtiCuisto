<?php $title = "Inscription"; ?>

<?php ob_start(); ?>

<div class="form-container container">
    <h1>S'inscrire</h1>

    <?php if($error !== "") : ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form action="./index.php?action=updateUserPost" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="nickname">Nom d'utilisateur : <?php $user->use_nickname ?></label></td>
                    <td><input type="text" name="nickname" id="nickname" value="<?php $user->use_nickname ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="firstname">Prénom : <?php $user->use_firstname ?> </label></td>
                    <td><input type="text" name="firstname" id="firstname" value="<?php $user->use_firstname ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="lastname">Nom : <?php $user->use_name ?> </label></td>
                    <td><input type="text" name="lastname" id="lastname" value="<?php $user->use_name ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="email">Email : <?php $user->use_email ?> </label></td>
                    <td><input type="email" name="email" id="email" value="<?php $user->use_email ?>" maxlength="32" required> </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Modifier mon compte&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
    <p>
        J'ai déja un compte ? Cliquez <a href="./index.php?action=login">ici</a>.
    </p>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>