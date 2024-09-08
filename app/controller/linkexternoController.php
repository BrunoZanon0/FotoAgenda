<?php

class LinkexternoController{

    public function decrypt(){
        $base64_encoded = json_encode($_GET);

        $json_encoded = base64_decode($base64_encoded);
        
        parse_str($json_encoded, $params);
        
        $id     = isset($params['id']) ? $params['id'] : null;
        $token  = isset($params['token']) ? $params['token'] : null;

        if(empty($id) || empty($token)){
            header("location: notfound");
        }

        include_once __DIR__ ."/../../public/views/home/cadastrarDataViaToken.php";
    }
}