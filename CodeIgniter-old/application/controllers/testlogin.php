<?php

    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        class Testlogin extends CI_Controller {

            public function __construct(){

            parent::__construct();
        }
        public function index()
        {
            //header('Location: ..\..\..\dmstree\dashboard.php');
            $this->load->view('pages/home');
        }
    }
       
?>