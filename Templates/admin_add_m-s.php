<?php
include ('../Modules/addmovie-serie.php');
$add = addMovieSerie();
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
<div class="container-fluid">
    <h1 class="text-center">Movie/Serie Toevoegen</h1>
    <a href="/admin/panel" class="text-warning"><i class="bi bi-arrow-return-left"></i>Terug gaan naar paneel</a><br><br>
    <form method="post">
        <div class="mb-3">
            <label for="name">Naam</label>
            <input type="text" class="form-control bg-dark text-white" placeholder="Naam van film/serie" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Beschrijving</label>
            <textarea class="form-control bg-dark text-white" id="exampleFormControlTextarea1" rows="3" name="summary" placeholder="beschrijving van het film/serie"></textarea>
        </div>
        <div class="mb-3">
            <label for="date">Datum</label>
            <input type="date" class="form-control bg-dark text-white" placeholder="Datum van film/serie" id="date" name="date">
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-10 col-12 mt-md-0 mt-3">
                    <label for="image">Afbeelding(Alleen url's)</label>
                    <input type="text" class="form-control bg-dark text-white" placeholder="Afbeelding van film/serie" id="image" name="imgInput">
                </div>
                <div class="col-md-2 col-12 mt-md-0 mt-3">
                    <img class="img-fluid rounded imgMS" src="" alt="">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="actors">Acteurs</label>
            <input type="text" class="form-control bg-dark text-white" placeholder="Acteurs van film/serie" id="actors" name="actorsInput">
        </div>
        <div class="mb-3">
            <label for="type">Type</label>
            <select class="form-select bg-dark text-white" aria-label="Default select example" name="type">
                <option selected>Kies een type</option>
                <option value='movies'>Film</option>
                <option value='series'>Serie</option>";
            </select>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-9 col-12 mt-md-0 mt-3">
                    <label for="trailer">Trailer(Alleen url's/ gebruikt youtube embed)</label>
                    <textarea class="form-control bg-dark text-white trailerMS" placeholder="Trailer van film/serie" name="trailerInput" id="trailer" rows="3"></textarea>
                </div>
                <div class="col-md-3 col-12 mt-md-0 mt-3">
                    <div class="trailer"></div>
                    <div class="changedtrailer"></div>
                </div>
            </div>
            <p class="fs-6">Plak deze template zo kan de trailer netjes op de site komen. Bij src set je de url.</p>
            <textarea class="form-control bg-gradient" disabled placeholder="Trailer van film/serie" id="trailer" rows="2">&lt;iframe class="img-fluid h-100 w-100" src="Jouw url" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe&gt;</textarea>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-9 col-12 mt-md-0 mt-3">
                    <label for="videoInput">Video(Alleen url's/ gebruikt vidsrc api)</label>
                    <textarea class="form-control bg-dark text-white videoMS" placeholder="Video van film/serie" id="videoInput" name="videoInput" rows="4"></textarea><br>
                </div>
                <div class="col-md-3 col-12 mt-md-0 mb-md-0 mb-5">
                    <div class="video"></div>
                    <div class="changedvideo"></div>
                </div>
            </div>
            <p class="fs-6">Plak deze template zo kan de video netjes op de site komen. Bij src set je de url.</p>
            <textarea class="form-control bg-gradient" disabled placeholder="Video van film/serie" id="video" rows="2">&lt;div class="ratio ratio-16x9"> <iframe class="img-fluid h-100 w-100" src="Jouw url" referrerpolicy="origin" allow="web-share" allowfullscreen></iframe></div&gt;</textarea>
        </div>
        <p class="fs-5">Genre:</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="genre[]" id="1">
            <label class="form-check-label" for="1">
                Action
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="2" id="2" name="genre[]">
            <label class="form-check-label" for="2">
                Comedy
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="3" name="genre[]" id="3">
            <label class="form-check-label" for="3">
                Thriller
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="4" name="genre[]" id="4">
            <label class="form-check-label" for="4">
                Fantasy
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="5" name="genre[]" id="5">
            <label class="form-check-label" for="5">
                Horror
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="6" name="genre[]" id="6">
            <label class="form-check-label" for="6">
                Drama
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="7" name="genre[]" id="7">
            <label class="form-check-label" for="7">
                Romance
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="8" name="genre[]" id="8">
            <label class="form-check-label" for="8">
                Adventure
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="9" name="genre[]" id="9">
            <label class="form-check-label" for="9">
                Crime
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="10" name="genre[]" id="10">
            <label class="form-check-label" for="10">
                Mystery
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="11" name="genre[]" id="11">
            <label class="form-check-label" for="11">
                Family
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="12" name="genre[]" id="12">
            <label class="form-check-label" for="12">
                Sci-Fi
            </label>
        </div>
        <br>
        <button type="submit" class="btn btn-warning" name="submit">Toevoegen</button>
    </form>
</div>
<script type="application/javascript" src="/js/update_input_admin_edit.js"></script>
</body>
<?php include_once ('defaults/footer.php')?>
</html>
