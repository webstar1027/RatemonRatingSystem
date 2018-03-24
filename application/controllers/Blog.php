<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_blog');
		$this->load->model('model_home');
		$this->load->library('user_agent');
	}
	

        
	public function index($slg)
	{
		$data['articles_data'] = $this->model_blog->all_articles_data($slg);
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('blog',$data);
		}
		else
		{
			$this->load->view('blog',$data);
		}
	}
	
	public function article($slg)
	{
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string)){
			
		}
		
		$data['articles_data'] = $this->model_blog->all_articles_data($slg);
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('blog',$data);
		}
		else
		{
			$this->load->view('blog',$data);
		}
	}
	
	public function send_comment()
	{
		$this->form_validation->set_rules('comment', 'Comment', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => array(
				'comment' => form_error('comment'),
			));
		}
		else
		{
			$save_comment = $this->model_home->save_comments($this->input->post());

			if($save_comment)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Comment saved successfully. Thank you for your comment.');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> You have to make changes to updated this comment.');
			}
		}
		echo json_encode($respond);
	}
	
	public function send_feedback()
	{
		$this->form_validation->set_rules('feedback', 'Feedback', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => array(
				'feedback' => form_error('feedback'),
			));
		}
		else
		{
			$save_feedback = $this->model_home->send_feedback($this->input->post());

			if($save_feedback)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Feedback send successfully. Thank you for your feedback.');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Sorry server error.');
			}
		}
		echo json_encode($respond);
	}
	
	public function send_contact()
	{
		$this->form_validation->set_rules('contact_name', 'Name', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('contact_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('contact_text', 'Message', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => array(
				'contact_name' => form_error('contact_name'),
				'contact_email' => form_error('contact_email'),
				'contact_text' => form_error('contact_text'),
			));
		}
		else
		{
			$save_contact = $this->model_home->send_contact($this->input->post());

			if($save_contact)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Contact send successfully. Thank you for your contact us.');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Sorry server error.');
			}
		}
		echo json_encode($respond);
	}
	
	function view_comments()
	{
		$people_id = $this->input->post('people_id');
		echo json_encode($this->model_home->view_comments($people_id));
	}
	
	function insert_person()
	{
		$result = $this->model_home->insert_person();
		echo json_encode($result);
	}
	
    function admin_email()
    {
		echo $result = $this->model_home->admin_email();
    }
	
	
	
}