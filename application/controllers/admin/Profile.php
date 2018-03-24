<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends Dashboard_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('model_profile');
		$this->load->library('form_validation');
	}
        
	public function index()
	{   
		$data['profile'] = $this->model_profile->get_user_info();
		view('admin/profile', $data);
	}
        
	function update_name()
	{
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				$respond = array('status' => 0, 'message' => form_error('full_name'));
		}
		else
		{
			$full_name = $this->input->post('full_name');
			
			if( ! $this->model_profile->update_name($full_name))
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
			}
			else
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Your profile name has been updated successfully');
			}
		}
		echo json_encode($respond);
	}
	
	function update_email()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				$respond = array('status' => 0, 'message' => form_error('email'));
		}
		else
		{
			$email = $this->input->post('email');
			
			if( ! $this->model_profile->update_email($email))
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
			}
			else
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Your profile email has been updated successfully');
			}
		}
		echo json_encode($respond);
	}
        
	function update_password()
	{   
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('retype_password', 'Password Confirmation', 'required|matches[password]');
		
		if ($this->form_validation->run() === FALSE)
		{
				$respond = array('status' => 0, 'message' => form_error('retype_password'));
		}
		else
		{
			$password = $this->input->post('password');
			
			if( ! $this->model_profile->update_password($password))
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
			}
			else
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Your Password has been updated successfully');
			}
		}
		echo json_encode($respond);
	} 
}