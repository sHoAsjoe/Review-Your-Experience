<?php
global $params;
//$params[2] is de action en $params[3] een getal die de action nodig heeft
//check if user has role admin
if (!isMember()) {
    logout();
    header ("location:/home");
} else {

    switch ($params[2]) {

        case 'edit':
            include_once ('../Templates/update_profile.php');
            break;
        case 'editp':
            include_once ('../Templates/update_profile_password.php');
            break;
        case 'editreview':
            include_once ('../Templates/update_review.php');
            break;
        case 'deletereview':
            include_once ('../Modules/delete_member_review.php');
            break;
    }
}