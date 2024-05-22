<?php
    $url = $_SERVER['REQUEST_URI'];
    $params = explode('/', $url);

    $type = $params[1];

    if ($type == 'films') {
        function display(){
            global $db;
            $query = $db->prepare("SELECT * FROM film order by id desc");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                echo "<div class='col-md-3 col-12 col-sm-6 mt-4 mt-md-0 d-flex d-md-block justify-content-center justify-content-md-start'>
                    <div class='card' style='width: 18rem;'>
                  <img src='{$data['image']}' class='card-img-top' alt='...'>
                  <div class='card-body bg-dark'>
                    <h4 class='card-title'><b>{$data['name']}</b></h4>
                    <p style='font-size: 11px'>{$data['summary']}<br><br>{$data['date']} | <span class='text-warning'>{$data['genre']}</span></p>
                    <a href='../{$data['type']}/{$data['id']}#ep' class='btn btn-warning text-white'>Watch now</a>
                    </div>
                    </div>
                    </div>";
            }
        }
    }

    if ($type == 'serie') {
        function display()
        {
            global $db;
            $query = $db->prepare("SELECT * FROM series order by id desc");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $data) {
                echo "<div class='col-md-3 col-sm-6 col-12 mt-4 mt-md-0 d-flex d-md-block justify-content-center justify-content-md-start'>
                    <div class='card' style='width: 18rem;'>
                  <img src='{$data['image']}' class='card-img-top' alt='...'>
                  <div class='card-body bg-dark'>
                    <h4 class='card-title'><b>{$data['name']}</b></h4>
                    <p style='font-size: 11px'>{$data['summary']}<br><br>{$data['date']} | <span class='text-warning'>{$data['genre']}</span></p>
                    <a href='../{$data['type']}/{$data['id']}#ep' class='btn btn-warning text-white'>Watch now</a>
                    </div>
                    </div>
                    </div>";
            }
        }
    }
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

<div class="container-fluid p-3">
    <div class="row">
        <?=display()?>
    </div>
</div>

</body>
<?php
include_once ('defaults/footer.php');
?>
</html>