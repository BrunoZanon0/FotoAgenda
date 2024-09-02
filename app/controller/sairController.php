<?php

class SairController{
    public function redirecionar(){
        session_start();
        session_destroy();
        header('location: login');
        exit();
    }
}