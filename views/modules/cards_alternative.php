<!--NO SE IMPLEMENTA YA QUE ES PARTE DE LA ALTERNATIVA PARA ACTUALIZAR LOS CARDS-->
<?php
include_once "../../models/model_dashboard.php";
include_once "../../controllers/controller_dashboard.php";
//Trae los laboratorios al dashboard
$lab = DashboardController::getLabController();
session_start();
?>

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

