<?php


class AdminViewController{

    static public function addLabController($data){

        $request = AdminViewModel::addLabModel($data);
        return $request;
    }
}