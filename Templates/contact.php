<?php
?>
<!DOCTYPE html>
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
    <div class="container-fluid pt-5"> <!-- Dit is de google map scherm -->
        <div class="row">
            <div class="col-md-6">
                <iframe class="m-4 rounded-1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2455.091164812323!2d4.347339175854939!3d52.02343687193528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5b5d771b631e7%3A0xcbe808e083d3d558!2sROC%20Mondriaan%20-%20Brasserskade!5e0!3m2!1snl!2sus!4v1704882149007!5m2!1snl!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="col-md-6 text-white"> <!-- Dit is de form waar je je contactgegevens kunt invullen -->
                <div class="m-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"><i class="bi bi-envelope-at-fill"></i> Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label"><i class="bi bi-patch-question"></i> Youre question</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Telephone" class="form-label"><i class="bi bi-telephone"></i> Telephone number</label> <br>
                        <input type="number" name="Telephone" class="form-control" id="exampleFormControlInput1" placeholder="+31623018197">
                    </div>
                    <button class="btn btn-warning">Send Form</button>
                </div>
            </div>
        </div>
    </div>
    </body>

    <?php
    include_once ('defaults/footer.php');
    ?>
    </html>
