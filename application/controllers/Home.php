<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//session_start(); //we need to call PHP's session object to access it through CI
class Home extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('testcrawl');
    }


    public function getFullName()
    {
        return $this->session->userdata('fullname');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('login', 'refresh');
    }
}
