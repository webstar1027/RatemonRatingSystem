<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservice extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_home');
		$this->load->model('model_people');
		$this->load->model('model_comments');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
	}
        
	public function index()
	{
		$search_name = $this->input->post('search_name');

		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->people_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('home',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	}
	
	public function get_data()
	{
		
		$data['people_data'] = $this->model_people->people_data();
		if(!empty($data['people_data']))
		{
			$data_array = array();
			$i=1;
			foreach ($data['people_data'] as $data)
			{
				$data_array[]				= $data;
			}
			
			$json['success']	= true;
			$json['status']		= 1;
			$json['payload']	= $data_array;
		}
		else
		{
			$json['success'] = false;
			$json['status'] = 0;
			$json['message'] = "Data Not Found!!";
		}
		echo json_encode($json);
	}
	
	public function send_blog_comment()
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
			$save_comment = $this->model_home->save_blog_comments($this->input->post());

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
	
	public function send_rating()
	{
		$data = $this->input->post();
		
		$is_rating = $this->model_home->is_rating($data);
		
		if($is_rating)
		{
			$respond = array('status' => 0, 'message' => 'Sorry, You have rated before.');
		}
		else
		{
			$save_rating = $this->model_home->save_rating($data);
			
			if($save_rating)
			{
				$respond = array('status' => 1, 'message' => 'Thanks for rating.');
			}
			else
			{
				$respond = array('status' => 0, 'message' => 'Server error');
			}
		}
		echo json_encode($respond);
	}
	
	function name_auto_complete()
	{
            //ini_set('display_errors', 1);

            $key = $this->input->post('key');
            echo json_encode($this->model_home->name_auto_complete($key));
	}
	
	function view_comments()
	{
		$people_id = $this->input->post('people_id');
		echo json_encode($this->model_home->view_comments($people_id));
	}
	
	function view_blog_comments()
	{
		$article_id = $this->input->post('article_id');
		echo json_encode($this->model_home->view_blog_comments($article_id));
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