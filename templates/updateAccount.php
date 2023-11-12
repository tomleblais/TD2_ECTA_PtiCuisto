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
                    <td><label for="nickname">Nom d'utilisateur : <?php UserManager::getUser($_SESSION["id"])->use_nickname ?></label></td>
                    <td><input type="text" name="nickname" id="nickname"  maxlength="32" required> <?php UserManager::getUser($_SESSION["id"])->use_nickname ?> </td>
                </tr>
                <tr>
                    <td><label for="firstname">Prénom : <?php UserManager::getUser($_SESSION["$id"])->use_firstname ?> </label></td>
                    <td><input type="text" name="firstname" id="firstname" maxlength="32" required> <?php UserManager::getUser($_SESSION["$id"])->use_firstname ?> </td>
                </tr>
                <tr>
                    <td><label for="lastname">Nom : <?php UserManager::getUser($_SESSION["$id"])->use_name ?> </label></td>
                    <td><input type="text" name="lastname" id="lastname" maxlength="32" required> <?php UserManager::getUser($_SESSION["$id"])->use_name ?> </td>
                </tr>
                <tr>
                    <td><label for="email">Email : <?php UserManager::getUser($_SESSION["$id"])->use_email ?> </label></td>
                    <td><input type="email" name="email" id="email" maxlength="32" required> <?php UserManager::getUser($_SESSION["$id"])->use_email ?> </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><button type="submit">Je modifie mon compte&mldr;</button></td>
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