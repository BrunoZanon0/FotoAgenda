<?php

session_start();

if(!isset($_SESSION['id'])){
    header('location: login');
    exit();
}

include_once __DIR__ . "/../model/userModel.php";
include_once __DIR__ . "/../model/datasModel.php";

class DashboardController {

    public $auth;

    public function __construct() {
        $user = new User($_SESSION['id']);
        $this->auth = $user->Auth();
    }

    public function render() {
        $auth = $this->auth;
        include_once __DIR__ ."/../../public/views/admin/dashboard.php";
    }

}

?>
