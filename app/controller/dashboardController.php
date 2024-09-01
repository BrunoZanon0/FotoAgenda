<?php

include_once __DIR__ . "/../model/userModel.php";

session_start();

class DashboardController {
    public function render() {
        $user = new User($_SESSION['id']);

        $auth = $user->Auth();

        include_once __DIR__ ."/../../public/views/admin/dashboard.php";
    }

}

?>
