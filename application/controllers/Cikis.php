<?php

class Cikis extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        unset($_SESSION["KULLANICI_ID"]);
        redirect(base_url());
    }

}

?>