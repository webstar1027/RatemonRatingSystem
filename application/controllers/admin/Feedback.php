<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_feedback');
		$this->load->library('form_validation');
	}
        
	function index()
	{
		$data['comments_data'] = $this->model_feedback->feedback_data();
		view('admin/feedback', $data);
	}
	
	function remove_feedback()
	{
		$id = $this->input->post('feedback_id');
		$status = $this->model_feedback->remove_feedback($id);
		if($status)
		{
			$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Feedback has been deleted successfully');
		}
		else
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
		}
		echo json_encode($respond);
	}
	
}