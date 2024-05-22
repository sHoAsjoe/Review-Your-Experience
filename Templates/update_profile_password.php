<?php
$displayMessage = "";
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $password = $user['password'];

    if (isset($_POST['send'])) {
        global $db;
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        if (password_verify($currentPassword, $password) && $newPassword == $confirmPassword) {
            $confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
            $query = $db->prepare("UPDATE user SET password = :pass WHERE email = :email");
            $query->bindParam(':email', $user['email']);
            $query->bindParam(':pass', $confirmPassword);
            $query->execute();

            $_SESSION['user']['password'] = $confirmPassword;
            $displayMessage = "<div class='alert alert-success' role='alert'>Het is gelukt</div>";
        } else {
            $displayMessage = "<div class='alert alert-danger' role='alert'>Er is iets misgegaan. Kijk als je alles goed heeft ingevoerd</div>";
        }
    }
} else {
    header("Location: home");
}
?>

<!doctype html>
<html lang="en">
<?php
include_once('defaults/head.php');
?>
<?php
include_once ('defaults/header.php');
include_once ('defaults/menu.php');
include_once ('defaults/pictures.php');
?>

<body>
<div class="container-fluid p-5">
    <?=$displayMessage?>
    <form method="post">
        <input type="text" class="getImage" name="p-image" hidden>
        <div class="row g-3">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Huidige wachtwoord</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="current-password" placeholder="MyPassword@#1!">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nieuwe wachtwoord</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="new-password" placeholder="MyPassword@45">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Bevesteging wachtwoord</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="confirm-password" placeholder="MyPassword@45">
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-warning" name="send">Veranderen!</button>
    </form>
</div>
</body>
<?=include_once ('defaults/footer.php')?>
</html>
