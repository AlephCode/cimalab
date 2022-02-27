<?php
    //Guarda la url que fue definida en el controlador del template
    //Para posteriormente utilizarla en el template sin tener que escribir cada vez la url completa
    $url = TemplateController::getUrlController();
//    var_dump($url);
//    session_start();
    include "index.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--    Estandar mas que nada cosas de User Interface      -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CimaLAb</title>
    <!-- Bootstrap 5 -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--    Bootstrap JS    -->
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FONT AWESOME   -->
    <script src="https://kit.fontawesome.com/18f8cc7063.js" crossorigin="anonymous"></script>
    <!--   ESTILOS PERSONALIZADOS     -->
    <link rel="stylesheet" type="text/css" href="views/assets/css/style.css">

</head>
<body>

<input type="hidden" class="url" value="<?php echo $url?>">

<?php

if($login_button == ''){

    echo '<div>Bienvenido Cimarron</div>';
    echo '<h3><b>Name: </b>'.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
    echo '<h3><b>Email: </b>'.$_SESSION['user_email_adress'].'</h3>';
    echo '<h3><a href="logout.php">Logout</a></h3>';

}else{
    echo '<div>'.$login_button.'</div>';
}
//            include "modules/login.php";

?>


</body>
</html>



