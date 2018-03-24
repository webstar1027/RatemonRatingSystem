<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard {
    
    public function logged_in()
    {
        $CI =& get_instance();
        $CI->load->library('session');

        if($CI->session->userdata('logged_in') == FALSE)
        {
            redirect('login');
        }
    }
}
