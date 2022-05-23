<?php
$mysqli = new mysqli('localhost', 'root', '', 'cimalab');

$id_laboratory = $_POST['id_laboratory'];
$chipid = $_POST ['chipid'];
$matricula = $_POST['matricula'];


//Inserta el chipID del ESP8266, la matricula del alumno
// y el id del laboratorio correspondiente en la tabla laboratories_users,
// aqui se hace la relacion entre el laboratory y laboratories_users*/
$request = $mysqli->query("INSERT INTO `cimalab`.`laboratories_users` (`id`, `chipId`, `id_laboratory`,`matricula`) VALUES (NULL, '$chipid', '$id_laboratory','$matricula')");

//Incrementa la cantidad (amount) en la tabla laboratory
$request2 = $mysqli->query("UPDATE laboratories set amount=amount+1 WHERE id='$id_laboratory'");

//Esto no garantiza para nada que se ingresaron los datos correctamente
echo "Datos ingresados correctamente.";