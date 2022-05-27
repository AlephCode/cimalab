<?php
//Trae los laboratorios al dashboard
    $lab = DashboardController::getLabController();
//    print_r($lab);
//    $lab_users = DashboardController::getLabUsersController();
//    var_dump($lab);

?>

<div>
    <!--HEADER-->
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
                    <a class="nav-item nav-link" href="views/modules/logout.php">Cerrar Sesión</a>
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
                            <div class="icon"> <i class="fa-solid fa-flask"></i> </div>
                            <div class="ms-2 c-details">
                                <h6 class="mb-0">Laboratorio</h6> <span>No.<?php echo ($key+1)?></span>
                            </div>
                        </div>
                        <div class="badge"> <span value="" class="span-status<?php echo ($key+1)?>"></span> </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="heading">Laboratorio<br><?php echo $value["name"]?></h3>
                        <div class="mt-5">
                            <div class="progress">
                                <div class="progress-bar<?php echo ($key+1)?>" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between px-1">
                                <div class="mt-3">
                                    <span class="text1 lab-amount" value="<?php echo $value["amount"]?>"><?php echo $value["amount"]?> Alumnos
                                        <span class="text2">de <?php echo $value["max"] ?> de capacidad</span>
                                        <input class="hidden_limit<?php echo ($key+1)?>" type="hidden" value="<?php echo $value["max"]?>">
                                    </span>
                                </div>
                                <div type="button" data-target="#lab_users_modal" class="mt-3 btn btn-warning card_userList" data-toggle="modal"  value="<?php echo $value['id']?>"><i class="fa-solid fa-eye"></i></div>
                                <?php
                                    if(!$_SESSION["IsOnLab"]){
                                        echo "<div class='mt-3 btn btn-primary card_userAdd'  email='".$_SESSION["user_email_adress"]."' value='".$value['id']."'>Entrar</div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach;?>
        </div>
    </div>


</div>


<!-- Modal -->
<div class="modal fade" id="lab_users_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alumnos en laboratorio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table" id="">
                        <thead class="thead-dark" >
                        <tr>
                            <th>Matrícula</th>
                            <th>Hora</th>

                        </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td id="modal-usersList-matricula"></td>
                                <td id="modal-usersList-time"></td>

                            </tr>

                        </tbody>
                    </table>

                </div>

            </div>
            <div class="modal-footer">
                <a href="/cimalab/views/modules/report.php" class="btn btn-danger float-start"><i class="fas fa-print"></i>.pdf</a>
                <a href="/cimalab/views/modules/excel_report.php" class="btn btn-success float-start"><i class="fas fa-print"></i>.xlsx</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>



