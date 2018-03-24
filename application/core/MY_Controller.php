<?php

class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
}

class Dashboard_Controller extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if($this->session->userdata('logged_in') == FALSE)
        {
            redirect('admin/login');
        }
    }
}


