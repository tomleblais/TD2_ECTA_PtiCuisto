<?php $title = "Mise à jour des mes informations"; ?>

<?php ob_start(); ?>

    <h1>Mettre à jour mes informations</h1>

    <?php if(isset($error) && $error !== "") : ?>
        <p><?= $error ?></p>
    <?php endif; ?>

<div class="form-container container">
    <form action="./index.php?action=updateAccountPost&id=<?= $_SESSION['id'] ?>" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="nickname">Nom d'utilisateur :<?= $user->use_nickname ?></label></td>
                    <td><input type="text" name="nickname" id="nickname" value="<?= $user->use_nickname ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="firstname">Prénom :<?= $user->use_firstname ?> </label></td>
                    <td><input type="text" name="firstname" id="firstname" value="<?= $user->use_firstname ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="lastname">Nom :<?= $user->use_lastname ?> </label></td>
                    <td><input type="text" name="lastname" id="lastname" value="<?= $user->use_lastname ?>" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="email">Email :<?= $user->use_email ?> </label></td>
                    <td><input type="email" name="email" id="email" value="<?= $user->use_email ?>" maxlength="32" required> </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Je change mes informations&mldr;</button></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<div class="form-container container">
    <form action="./index.php?action=updatePasswordPost&id=<?= $_SESSION['id'] ?>" method="post">
        <table>
            <tbody>
                <tr>
                    <td><label for="oldpassword">Mot de passe actuel :</label></td>
                    <td><input type="password" name="oldpassword" id="oldpassword" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="newpassword">Nouveau mot de passe :</label></td>
                    <td><input type="password" name="newpassword" id="newpassword" maxlength="32" required> </td>
                </tr>
                <tr>
                    <td><label for="newpassword2">Confirmer votre nouveau mot de passe :</label></td>
                    <td><input type="password" name="newpassword2" id="newpassword2" maxlength="32" required> </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="email" id="email" maxlength="32" value="<?php $user->use_email ?>">
                        <button type="submit">Je change mon mot de passe&mldr;</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>