<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_comments extends Dashboard_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_blog_comments');
		$this->load->library('form_validation');
	}
        
	function index()
	{
		$data['comments_data'] = $this->model_blog_comments->comments_data();
		view('admin/blog_comments', $data);
	}
	
	function update_comment()
	{
		$this->form_validation->set_rules('comment', 'Comment', 'required|alpha_numeric_spaces');
		
		if ($this->form_validation->run() === FALSE)
		{
			$respond = array('status' => 0, 'message' => array(
				'comment'      => form_error('comment'),
			));
		}
		else
		{
			$update_comment = $this->model_blog_comments->update_comment($this->input->post());

			if($update_comment)
			{
				$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Comment has been updated successfully');
			}
			else
			{
				$respond = array('status' => 0, 'message' => '<strong>Error :</strong> You have to make changes to updated this comment.');
			}
		}
		echo json_encode($respond);
	}
	
	function remove_comment()
	{
		$id = $this->input->post('comment_id');
		$status = $this->model_blog_comments->remove_comment($id);
		if($status)
		{
			$respond = array('status' => 1, 'message' => '<strong>Success :</strong> Comment has been deleted successfully');
		}
		else
		{
			$respond = array('status' => 0, 'message' => '<strong>Error :</strong> Server are too busy right now try again later');
		}
		echo json_encode($respond);
	}
	
    function comment_data()
    {
		$id = $this->input->post('comment_id');
		echo json_encode($this->model_blog_comments->get_comment_data($id));
    }
	
}