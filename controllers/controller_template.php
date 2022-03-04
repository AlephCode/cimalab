<?php
class TemplateController{

    static public function initTemplate(){

        include "views/template.php";

    }

    static public function getUrlController(){
        return "http://localhost/cimalab/";
    }
}