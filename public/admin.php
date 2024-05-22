<?php
global $params;

//check if user has role admin
if (!isAdmin()) {
    logout();
    header ("location:/home");
} else {
/* $params[2] is de action
   $params[3] is een getal die de delete action nodig heeft
*/
    switch ($params[2]) {
        case 'edit':
            include_once ('../Templates/update_profile.php');
            break;
        case 'editp':
            include_once ('../Templates/update_profile_password.php');
            break;
        case 'panel':
            include_once ('../Templates/adminPanel.php');
            break;
        case 'edituser':
            include_once('../Templates/admin_update_user.php');
            break;
        case 'editmovie':
            include_once('../Templates/admin_edit_m-s.php');
            break;
        case 'editserie':
            include_once('../Templates/admin_edit_m-s.php');
            break;
        case 'addms':
            include_once('../Templates/admin_add_m-s.php');
            break;
    }
    if (isset($params[3])) {
        switch ($params[3]) {
            case 'userspanel':
                include_once('../Templates/show_user.php');
                break;
            case 'm-spanel':
                include_once('../Templates/show_movies_series.php');
                break;
            case 'reviewpanel':
                include_once('../Templates/show_reviews.php');
                break;
        }
    }
    if (isset($params[4])) {
        switch ($params[4]) {
            case 'deleteuser':
                include_once('../Modules/delete_user.php');
                break;
            case 'deletemovie':
                include_once('../Modules/delete_movie.php');
                break;
            case 'deleteserie':
                include_once('../Modules/delete_serie.php');
                break;
            case 'deletereview':
                include_once('../Modules/delete_review.php');
                break;
        }
    }
}