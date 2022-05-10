<?php
$mysqli = new mysqli('localhost', 'root', '', 'cimalab');


$chipid = $_POST ['chipid'];
$temperatura = $_POST ['temperatura'];

$res = $mysqli->query("INSERT INTO `cimalab`.`laboratories_users` (`id`, `chipId`, `temperatura`) VALUES (NULL, '$chipid', '$temperatura')");


echo "Datos ingresados correctamente.";