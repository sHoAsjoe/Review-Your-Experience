<?php
if (!$_SESSION['user']['role'] == "member" || !$_SESSION['user']['role'] == "admin") {
    exit("Cannot access this page");
}

global $db;
global $params;

$query = $db->prepare("SELECT * FROM review WHERE id = :id");
$query->bindParam(":id", $params[2]);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

for ($i = 1; $i <= 5; $i++) {
    if ($result['stars'] == $i) {
        ${"star" . $i} = "checked";
    } else {
        ${"star" . $i} = "";
    }
}
if (isset($_POST['submit'])) {
    $id = $params[2];
    $rating = $_POST['star-radio'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user']['id'];
    $query = $db->prepare("UPDATE review SET stars = :rating, message = :message WHERE id = :id");
    $query->bindParam(":rating", $rating);
    $query->bindParam(":message", $message);
    $query->bindParam(":id", $id);
    $query->execute();
    header("location:/home");
}
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
<div class="container-fluid p-5">
    <?php echo "<form method='post'>
        <div class='card text-white bg-dark border border-warning'>
            <div class='card-body'>
                <img src='/{$_SESSION['user']['profile_pic']}' alt='' style='height: 29px; border-radius: 25px; float: left;'>
                <h5 class='card-title'>&nbsp;~{$_SESSION['user']['first_name']}&nbsp;{$_SESSION['user']['last_name']}</h5>
                <div class='rating float-start mb-3 mt-3'>

                    <input type='radio' id='1' name='star-radio' value='5' {$star5}>
                    <label for='1'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                    <input type='radio' id='2' name='star-radio' value='4' {$star4}>
                    <label for='2'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                    <input type='radio' id='3' name='star-radio' value='3' {$star3}>
                    <label for='3'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                    <input type='radio' id='4' name='star-radio' value='2' {$star2}>
                    <label for='4'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                    <input type='radio' id='5' name='star-radio' value='1' {$star1}>
                    <label for='5'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><path pathLength='360' d='M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z'></path></svg>
                    </label>
                </div>
                <br><br><br>
                <label for='message'>Bericht(Optioneel):</label>
                <textarea type='text' name='message' class='form-control' id='message' placeholder='Voer jouw bericht toe'>{$result['message']}</textarea><br>
                <button type='submit' name='submit' class='btn btn-outline-warning'>Recensie Aanpassen</button>
            </div>
        </div>
    </form>"?>
</div>
</body>

<?php
include_once ('defaults/footer.php');
?>
</html>
