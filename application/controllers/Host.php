<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//session_start(); //we need to call PHP's session object to access it through CI
class Host extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ourmodel','',TRUE);
        $this->load->model('productmodel','',TRUE);
    }

    public function index() {

        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $this->load->view('header', $data);
        $this->load->view('topbar', $session_data);
        $this->load->view('sidebar', $session_data);


        $data['hasil'] = $this->productmodel->get_products();
        $this->load->view('master_host',$data);
    }

    function valid_url($url)
    {
      return filter_var($url, FILTER_VALIDATE_URL);
    }
}
