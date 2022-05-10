<?php

require_once "connection.php";

class AdminViewModel{


    static public function addLabModel($data){

        $stmt = Conexion::connect()->prepare(
            "INSERT INTO laboratories(name,max)
                    VALUES(:name,:max)"
        );

        $stmt->bindParam(":name",$data["labName"],PDO::PARAM_STR);
        $stmt->bindParam(":max",$data["labCapacity"],PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return print_r(ConnectionDB::connect()->errorInfo());
        }
    }

}