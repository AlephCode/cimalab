<?php
include "connection.php";

$mysqli = new mysqli('localhost', 'root', '', 'cimalab');

$id_laboratory = $_POST['id_laboratory'];
$chipid = $_POST ['chipid'];
$matricula = $_POST['matricula'];




$stmt = Conexion::connect()->prepare("SELECT * FROM laboratories WHERE id = 3");

$stmt->execute();

$num = $stmt->fetchAll();

if($num[0][2] < $num[0][3]){
    //Inserta el chipID del ESP8266, la matricula del alumno
// y el id del laboratorio correspondiente en la tabla laboratories_users,
// aqui se hace la relacion entre el laboratory y laboratories_users*/
    $request = $mysqli->query("INSERT INTO `cimalab`.`laboratories_users` (`id`, `chipId`, `id_laboratory`,`matricula`) VALUES (NULL,
                                                                                                 '$chipid', '$id_laboratory','$matricula')");

//Incrementa la cantidad (amount) en la tabla laboratory
    $request2 = $mysqli->query("UPDATE laboratories set amount=amount+1 WHERE id='$id_laboratory'");
    //Esto no garantiza para nada que se ingresaron los datos correctamente
    echo "1";//"Datos ingresados correctamente.";
}else{
    echo "00000000000000";//Laboratorio lleno
}


