<?php
require_once "connection.php";
class DashboardModel{

    public static function getLabModel(){
        $stmt = Conexion::connect()->prepare("SELECT * FROM laboratories");

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
