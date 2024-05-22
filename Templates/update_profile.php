<?php
$displayMessage = "";
 if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $fname = $user['first_name'];
        $lname = $user['last_name'];
        $email = $user['email'];

        if (isset($_POST['send'])) {
            global $db;
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $validateEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            if ($validateEmail && !empty($fname) && !empty($lname)) {
                $query = $db->prepare("UPDATE user SET first_name = :fname, last_name = :lname, email = :email WHERE id = :id");
                $query->bindParam(':fname', $fname);
                $query->bindParam(':lname', $lname);
                $query->bindParam(':email', $email);
                $query->bindParam(':id', $user['id']);
                $query->execute();

                $_SESSION['user']['first_name'] = $fname;
                $_SESSION['user']['last_name'] = $lname;
                $_SESSION['user']['email'] = $email;

                $displayMessage = "<div class='alert alert-success' role='alert'>Het is gelukt</div>";
            } else {
                $displayMessage = "<div class='alert alert-danger' role='alert'>Vul alle velden in of email is niet geldig!</div>";
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
                <div class="col">
                    <label for="fname" class="form-label">Voornaam</label>
                    <input type="text" class="form-control" placeholder="John" value="<?=$fname?>" id="fname" name="fname">
                </div>
                <div class="col">
                    <label for="lname" class="form-label">Achternaam</label>
                    <input type="text" class="form-control" placeholder="Doe" value="<?=$lname?>" id="lname" name="lname">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="12345678@gmail.com" value="<?=$email?>">
                    <div id="emailHelp" class="form-text">We zullen uw e-mailadres nooit met iemand anders delen.</div>
                </div>
            </div>
            <a href="editp" class="text-warning">Wachtwoord veranderen? Klik hier!</a><br><br>
            <button type="submit" class="btn btn-warning" name="send">Veranderen!</button>
        </form>
    </div>
</body>
<?=include_once ('defaults/footer.php')?>
</html>
