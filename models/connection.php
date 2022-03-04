<?php

class Conexion{

    static public function connect(){

        $link = new PDO("mysql:host=localhost:3307;dbname=cimalab","root","");

        $acentos = $link->query("SET NAMES 'utf8'");

        return $link;
    }
}
