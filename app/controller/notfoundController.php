<?php

class NotfoundController{
    public function exit(){
        session_start();
        session_destroy();
        header("location: notfound.php ");
        exit();
    }
}