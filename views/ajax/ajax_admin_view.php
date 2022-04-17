<?php
//Controllers
require_once "../../controllers/controller_admin_view.php";

//Models
require_once "../../models/model_admin_view.php";

session_start();

class AdminViewAjax{

    public $dataAdminView;
    public $controllerAdminView;

    public function functionAdminViewAjax(){

        $dataAdminView = $this->dataAdminView;
        $controllerAdminView = $this->controllerAdminView;

        $request = AdminViewController::$controllerAdminView($dataAdminView);
        echo $request;
    }

}

if(isset($_POST["labName"])){


    $data = array(
        "labName" => $_POST['labName'],
        "labCapacity" => $_POST['labCapacity']
    );


    $a = new AdminViewAjax();
    $a -> dataAdminView = $data;
    $a -> controllerAdminView = "addLabController";
    $a -> functionAdminViewAjax();
}