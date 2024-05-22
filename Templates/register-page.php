<?php
$errorMessage = '';
   if (isset($_POST['send'])) {

       $result = makeRegistration();
         if ($result == 'EXIST') {
              $errorMessage = "<div class='alert alert-danger' role='alert'>Deze email bestaat al!</div>";
         } elseif ($result == 'INCOMPLETE') {
              $errorMessage = "<div class='alert alert-danger' role='alert'>Vul alle velden in of email is niet geldig</div>";
         } elseif ($result == 'SUCCESS') {
              $errorMessage = "<div class='alert alert-success' role='alert'>U bent succesvol geregistreerd!</div>";
         }
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<?php
include_once('defaults/head.php');
?>
<?php
include_once ('defaults/header.php');
include_once ('defaults/menu.php');
include_once ('defaults/pictures.php');
?>
<link rel="stylesheet" href="/css/addprofileicon.css">
<body>
<br><br>
<div class="container-fluid w-75 p-3">
    <?= $errorMessage ?>
    <h2>Registreren</h2><br>
    <form method="post" enctype="multipart/form-data">
        <input type="text" class="getImage" name="p-image" hidden>
        <div class="row g-3">
            <div class="col">
                <label for="fname" class="form-label">Voornaam</label>
                <input type="text" class="form-control" placeholder="John" id="fname" name="fname">
            </div>
            <div class="col">
                <label for="lname" class="form-label">Achternaam</label>
                <input type="text" class="form-control" placeholder="Doe" id="lname" name="lname">
            </div>
        </div>
        <br>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="12345678@gmail.com">
            <div id="emailHelp" class="form-text">We zullen uw e-mailadres nooit met iemand anders delen.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="MyPassword@#1!">
        </div>
        <br>
        <label for="inputGroupFile04">Profile foto (optioneel)</label>
        <br><br>
        <div class="row">
            <div class="col-md-9 col-12">
                <div class="input-div">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                    <input class="input" name="file" type="file" accept="image/*">
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="response-image">
                    <div class="img-container mt-md-0 mt-3"></div>
                    <p class="info mt-md-0 mt-3">Geen bestanden geselecteerd</p>
                </div>
            </div>
        </div>
        <br>
        <a href="login" class="text-warning">Heeft u wel een account? login hier!</a><br><br>
        <button type="submit" class="btn btn-warning" name="send">Registreren</button>
    </form>
</div>
<br><br><br>

<script type="application/javascript" src="/js/displayProfileImage.js"></script>
</body>
<?php
include_once ('defaults/footer.php');
?>
</html>

