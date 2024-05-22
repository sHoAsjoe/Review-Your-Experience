<?php
$Message = checkLogin();
?>

<!doctype html>
<html>
<?php
include_once('defaults/head.php');
?>
<?php
include_once ('defaults/header.php');
include_once ('defaults/menu.php');
include_once ('defaults/pictures.php');
?>
<body>
<br><br>
<div class="container-fluid w-75 p-3">
    <?= $Message ?>
    <h2>Login</h2><br>
<form method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="email@email.com">
        <div id="emailHelp" class="form-text">We zullen uw e-mailadres nooit met iemand anders delen.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="MyPassword@#1!">
    </div>
    <a href="register" class="text-warning">Heeft u geen account? Registreer hier!</a><br><br>
    <button type="submit" class="btn btn-warning" name="send">Login</button>
</form>
</div>
<br><br><br>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>
