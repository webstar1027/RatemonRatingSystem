<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_people');
		$this->load->library('form_validation');
	}
        
	function index()
	{
		$data['people_data'] = $this->model_people->people_data();
		view('admin/people', $data);
	}
	
	
	function insert_people()
	{
		$result = $this->model_people->insert_people();
		echo json_encode($result);
	}
	
	function update_people()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => array(
				'name'      => form_error('name'),
			));
		}
		else
		{
			$update_people = $this->model_people->update_people();

			if($update_people)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> People information has been updated successfully');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> You have to make changes to updated this people.');
			}
		}
		echo json_encode($respond);
	}

    function people_data()
    {
		$id = $this->input->post('people_id');
		echo json_encode($this->model_people->get_people_data($id));
    }
        
	function remove_people()
	{
		$id = $this->input->post('people_id');
		$status = $this->model_people->remove_people($id);
		if($status)
		{
			$respond = array('status' => 1, 'message' => '<strong>Success :</strong> People has been deleted successfully');
		}
		else
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
		}
		echo json_encode($respond);
	}
	
    function calculat_rating()
    {
		$data = $this->model_people->calculat_rating();
		
		print_r($data);
    }
	

}