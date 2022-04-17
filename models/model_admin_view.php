<?php

require_once "connection.php";

class AdminViewModel{


    static public function addLabModel($data){

        $stmt = Conexion::connect()->prepare(
            "INSERT INTO laboratories(name,amount)
                    VALUES(:name,:amount)"
        );

        $stmt->bindParam(":name",$data["labName"],PDO::PARAM_STR);
        $stmt->bindParam(":amount",$data["labCapacity"],PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return print_r(ConnectionDB::connect()->errorInfo());
        }
    }

}