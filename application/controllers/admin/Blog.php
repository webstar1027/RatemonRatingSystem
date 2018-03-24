<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_blog');
		$this->load->library('form_validation');
	}
        
	function index()
	{
		$data['articles_data'] = $this->model_blog->all_articles_data();
		view('admin/blog', $data);
	}
	
	
	function new_article()
	{
		$this->form_validation->set_rules('topic', 'Topic', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> All filed are required.');
		}
		else
		{
			
			$result = $this->model_blog->new_article($this->input->post());
			
			if($result)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Article has been add successfully');
				$this->session->set_flashdata('message', '<strong>Success :</strong> Article has been add successfully');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later.');
			}
		}
		echo json_encode($respond);
	}
	
    function article_data()
    {
		$id = $this->input->post('article_id');
		echo json_encode($this->model_blog->article_data($id));
    }
	
	function update_article()
	{
		$this->form_validation->set_rules('topic', 'Topic', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> All filed are required.');
		}
		else
		{
			$update_article = $this->model_blog->update_article($this->input->post());

			if($update_article)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Article has been updated successfully');
				$this->session->set_flashdata('message', '<strong>Success :</strong> Article has been updated successfully.');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> You have to make changes to updated this article.');
			}
		}
		echo json_encode($respond);
	}
        
	function delete_article()
	{
		$id = $this->input->post('article_id');
		$status = $this->model_blog->delete_article($id);
		if($status)
		{
			$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Article has been deleted successfully.');
			$this->session->set_flashdata('message', '<strong>Success :</strong> Article has been deleted successfully.');
		}
		else
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
		}
		echo json_encode($respond);
	}
	

}