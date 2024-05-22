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

    <?php
        global $db;
        $query = $db->prepare("SELECT * FROM film order by id desc");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $query1 = $db->prepare("SELECT * FROM series order by id desc");
        $query1->execute();
        $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
        function randomCarousel($r) {
            $snumber = [];
            $random = rand(0, count($r) - 1);
            array_push($snumber, $random);
            $data = $r[$random];
            echo "<div class='carousel-item active'>";
            echo "<a href='{$data['type']}/{$data['id']}#ep'>";
            echo "<img src='{$data['image']}' class='d-block w-100 img-fluid opacity-25' alt='...'>";
            echo "<div class='carousel-caption text-md-start text-center top-50 translate-middle-y mt-md-4 mt-0'>
                <h1><b>{$data['name']}</b></h1>
                <p class='fs-6'>{$data['date']}&nbsp;|&nbsp;<span class='text-warning'>{$data['genre']}</span</p>
                <p class='fs-5 d-md-block d-none'>{$data['summary']}</p>
                <button class='btn btn-warning text-white'>Watch Now</button>
              </div>";
            echo "</a>";
            echo "</div>";

            for ($i = 0; $i < 2; $i++) {
                $random1 = rand(0, count($r) - 1);
                array_push($snumber, $random1);
                for ($j = 0; $j < count($snumber); $j++) {
                    if ($random1 == $snumber[$j]) {
                        return;
                    } else {
                        $data1 = $r[$random1];
                        echo "<div class='carousel-item'>";
                        echo "<a href='{$data1['type']}/{$data1['id']}#ep'>";
                        echo "<img src='{$data1['image']}' class='d-block w-100 max-h-100 img-fluid opacity-25' alt='...'>";
                        echo "<div class='carousel-caption text-md-start text-center top-50 translate-middle-y mt-md-4 mt-0'>
                        <h1><b>{$data1['name']}</b></h1>
                        <p class='fs-6'>{$data1['date']}&nbsp;|&nbsp;<span class='text-warning'>{$data1['genre']}</span></p>
                        <p class='fs-5 d-md-block d-none'>{$data1['summary']}</p>
                        <button class='btn btn-warning text-white'>Watch Now</button>
                          </div>";
                        echo "</a>";
                        echo "</div>";
                    }
                }
            }

        }
        function displayMovies($r) {
            foreach ($r as $data) {
                echo "<div class='swiper-slide'>";
                echo "<a href='{$data['type']}/{$data['id']}'>";
                echo "<img src='{$data['image']}' alt='Movie'>";
                echo "</a>";
                echo "<p class='text-center fs-5'>{$data['name']}</p>";
                echo "</div>";
            }
        }
    ?>

    <body>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?=randomCarousel($result)?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <br><br>
    <div class="p-3">
        <p>Populair op MovieStatic</p>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?=displayMovies($result)?>

            </div>
        </div>
        <br><br><br>
        <p>Trending Aan</p>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?=displayMovies($result1)?>
        </div>
    </div>
    </div>
    <script type="application/javascript" src="/js/video.js"></script>
    </body>

    <?php
    include_once ('defaults/footer.php');
    ?>
</html>
