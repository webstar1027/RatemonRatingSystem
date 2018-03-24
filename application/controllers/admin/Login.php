<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
            parent::__construct();
            $this->load->model('model_login');
	}
        
	public function index()
	{
        if($this->session->userdata('logged_in'))
        {
            redirect('admin/main');
        }
        $this->load->view('admin/login');
	}
        
	public function check_login()
	{
            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('login_error', 'Input Error');
                redirect('login', 'refresh');
            }
            else
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                
                $login_data = $this->model_login->login($username, $password);

                if($login_data)
                {
                    if($login_data->active)
                    {
                        $this->model_login->set_logged_time($login_data->id);
                        $this->model_login->set_session($login_data);
                        redirect('admin/main');
                    }
                    else
                    {
                        $this->session->set_flashdata('login_error', 'Sorry your account inactive contact system administrators');
                        redirect('admin/login', 'refresh');
                    }
                }
                else
                {
                    $this->session->set_flashdata('login_error', 'Invalid username or password');
                    redirect('admin/login', 'refresh');
                }
            }
	}
        
	function terminate()
	{	
            $this->model_login->logout();
	}

}