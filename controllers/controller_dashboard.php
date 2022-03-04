<?php

class DashboardController{

    static public function getLabController(){

        $reply = DashboardModel::getLabModel();

        return $reply;
    }

}