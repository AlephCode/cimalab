<?php
require_once "connection.php";
class DashboardModel{

    public static function getLabModel(){
        $stmt = Conexion::connect()->prepare("SELECT * FROM laboratories");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getLabUsersModel($id){

        $stmt = Conexion::connect()->prepare("SELECT matricula FROM laboratories_users WHERE id_laboratory=:id");

        $stmt->bindParam(":id",$id,PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll();

    }

    public static function addUserLabModel($data){

        $stmt = Conexion::connect()->prepare("INSERT INTO laboratories_users(email,id_laboratory) VALUES(:email,:id_laboratory)");
        $stmt2 = Conexion::connect()->prepare("UPDATE laboratories set amount=amount+1 WHERE id=:id_laboratory");

        $stmt->bindParam(":email",$data["email"],PDO::PARAM_STR);
        $stmt->bindParam(":id_laboratory",$data["id_laboratory"],PDO::PARAM_INT);
        $stmt2->bindParam(":id_laboratory",$data["id_laboratory"],PDO::PARAM_INT);

        if($stmt->execute() && $stmt2->execute())
            return 'ok';
        else
            return print_r(ConnectionDB::connect()->errorInfo());
    }
}
