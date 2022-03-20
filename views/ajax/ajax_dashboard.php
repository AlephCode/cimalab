<?php
//Controllers
require_once "../../controllers/controller_dashboard.php";
//Models
require_once "../../models/model_dashboard.php";

session_start();

class DashboardAjax{

    public $dataDashboard;
    public $controllerDasboard;

    public function functionDashboard(){

        $dataDashboard = $this->dataDashboard;
        $controllerDasboard = $this->controllerDasboard;

        $_request = DashboardController::$controllerDasboard($dataDashboard);
        echo $_request;
    }
}

if(isset($_POST["modal_users_id"])){


    $dataDashboard = $_POST['modal_users_id'];


    $a = new DashboardAjax();
    $a -> dataDashboard = $dataDashboard;
    $a -> controllerDasboard = "getLabUsersController";
    $a -> functionDashboard();
}

if(isset($_POST["addUserInLab_email"])){


    $dataDashboard = array(
      "email"=>$_POST["addUserInLab_email"],
      "id_laboratory"=>$_POST["addUserInLab_id_laboratory"]
    );


    $a = new DashboardAjax();
    $a -> dataDashboard = $dataDashboard;
    $a -> controllerDasboard = "addUserLabController";
    $a -> functionDashboard();
}