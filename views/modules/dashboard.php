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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeModalbtn">Close</button>
                </div>
            </div>
        </div>

    </div>


<!--    NO SE IMPLEMENTA YA QUE ES PARTE DE LA ALTERNATIVA PARA ACTUALIZAR LOS CARDS-->
<!--<div id="result"></div>-->



