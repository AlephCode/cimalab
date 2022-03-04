<?php

    $lab = DashboardController::getLabController();
//    var_dump($lab);
?>

<!--HEADER-->
<div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

        <div class="container-fluid">
            <!-- Links -->
            <a class="navbar-brand" href="#">
                <img src="views/assets/img/navbar_logo.png" alt="Logo" style="width:40px;" class="rounded-pill">
            </a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-item nav-link">
                        <img src="<?php echo $_SESSION['user_image']?>" width="30" height="30" class="rounded-circle" alt="">
                    </a>
                </li>
                <li class="nav-item">
                    <label class="nav-item nav-link"><?php echo $_SESSION['user_email_adress']; ?></label>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link"><?php echo $_SESSION['user_first_name'].' '.$_SESSION['user_last_name']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="views/modules/logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav>

<!--CARDS DE LABORATORIOS-->
    <div class="container mt-5 mb-3">
        <div class="row">

            <!--     Ciclo de laboratorios       -->
            <?php foreach ($lab as $key => $value):?>

            <div class="col-md-4">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div class="icon"> <i class="bx bxl-mailchimp"></i> </div>
                            <div class="ms-2 c-details">
                                <h6 class="mb-0">Laboratorio</h6> <span>No.<?php echo ($key+1)?></span>
                            </div>
                        </div>
                        <div class="badge"> <span value="" class="span-status<?php echo ($key+1)?>" status="<?php echo $value['status']?>"></span> </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="heading">Laboratorio<br><?php echo $value["name"]?></h3>
                        <div class="mt-5">
                            <div class="progress">
                                <div class="progress-bar progress-bar<?php echo ($key+1)?>" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-3"> <span class="text1 lab-amount" value="<?php echo $value["amount"]?>"><?php echo $value["amount"]?> Alumnos <span class="text2">de 7 de capacidad</span></span> </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach;?>
        </div>
    </div>


</div>

