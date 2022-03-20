<?php

class DashboardController{

    static public function getLabController(){

        $reply = DashboardModel::getLabModel();

        return $reply;
    }

    static public function getLabUsersController($id){

        $reply = DashboardModel::getLabUsersModel($id);

        echo json_encode($reply);

    }

    static public function addUserLabController($data){

        $reply = DashboardModel::addUserLabModel($data);

        echo $reply;

    }
}