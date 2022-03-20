<?php
//Google Auth Config
include "config.php";

//Controllers
require_once "controllers/controller_template.php";
require_once "controllers/controller_dashboard.php";

//Models
require_once "models/model_dashboard.php";


//VENDOR
require_once "vendor/autoload.php";

$url = TemplateController::getUrlController();

$login_button = '';

if(isset($_GET['code'])){

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token['error'])){

        $google_client-> setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        if(!empty($data['given_name'])){
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name'])){
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email'])){
            $_SESSION['user_email_adress'] = $data['email'];
        }

        if(!empty($data['gender'])){
            $_SESSION['user_gender'] = $data['gender'];
        }

        if(!empty($data['picture'])){
            $_SESSION['user_image'] = $data['picture'];
        }

    }

}

if(!isset($_SESSION['access_token'])){
    $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="views/assets/img/btn_google_signin_dark_normal_web.png"></a>';
}

//PENDIENTE SABER SI UTILIZO TEMPLATE Y no index
//Obtengo la plantilla y la inicializo
//$template = new TemplateController();
//$template -> initTemplate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--    Estandar mas que nada cosas de User Interface      -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CimaLAb</title>

    <!-- Bootstrap 5-->

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--    Bootstrap JS    -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FONT AWESOME   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--   ESTILOS PERSONALIZADOS     -->
    <link rel="stylesheet" type="text/css" href="views/assets/css/style.css">

</head>
<body>

<input type="hidden" class="url" value="<?php echo $url?>">

<?php

if($login_button == ''){
    include "views/modules/dashboard.php";
}else{
    include "views/modules/login.php";
}

?>

<!--Customizable-->
<script src="http://localhost/cimalab/views/assets/js/scripts/dashboard.js?'"></script>
<script src="http://localhost/cimalab/views/assets/js/scripts/general.js?'"></script>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</body>
</html>


