<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_home extends CI_Model
{
    public function __construct()
    {
            parent::__construct();
			$this->load->library('form_validation');
			$this->load->library('email');
			$this->load->helper('cookie');
    }

    function save_comments($params)
    {
		$ip_address = $this->getUserIP();
		
        $data = array(
			'people_id'  => $params['people_id'],
			'comment'    => $params['comment'],
			'ip_address' => $ip_address,
			'date'     => $this->date_time(),
        );
		
	    $this->db->insert('tbl_comments', $data);
	    $insert_id = $this->db->insert_id();
        
        if($insert_id)
        {
			if(isset($params['rating_id']))
			{
				$rating_data = array('comment_id'  => $insert_id);
				$this->db->where('id', $params['rating_id']);
				$this->db->update('tbl_rating', $rating_data);
			}
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
    function save_blog_comments($params)
    {
		$ip_address = $this->getUserIP();
		
        $data = array(
			'article_id' => $params['article_id'],
			'comment'    => $params['comment'],
			'ip_address' => $ip_address,
			'date'     => $this->date_time(),
        );
		
	    $this->db->insert('tbl_blog_comments', $data);
	    $insert_id = $this->db->insert_id();
        
        if($insert_id)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
    function send_feedback($params)
    {
		$ip_address = $this->getUserIP();
		$date = $this->date_time();
		
        $data = array(
			'feedback'   => $params['feedback'],
			'ip_address' => $ip_address,
			'date'       => $date
        );
		
	    $this->db->insert('tbl_feedback', $data);
	    $insert_id = $this->db->insert_id();
		
		$this->send_feedback_email($params['feedback']);
        
        if($insert_id)
        {
			return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
    function send_contact($params)
    {

		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$to_email = $this->admin_email();
		$message_body = $this->load->view('contact_email', $params ,true);
		
		$this->email->to($to_email);
		$this->email->from($params['contact_email'], $params['contact_name']);
		$this->email->subject('Contact from Ratemeon');
		$this->email->message($message_body);
		$email_send = $this->email->send();
		
        if($email_send)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
    function send_feedback_email($feedback)
    {
		
		$data['feedback'] = $feedback;
	
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		$to_email = $this->admin_email();
		$message_body = $this->load->view('feedback_email', $data ,true);
		
		$this->email->to($to_email);
		$this->email->from('no_replay@ratemeon.com', 'Ratemeon');
		$this->email->subject('Feedback from Ratemeon');
		$this->email->message($message_body);
		$email_send = $this->email->send();
		
        if($email_send)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
    function save_rating($params)
    {
		$ip_address = $this->getUserIP();
		$date = $this->date_time();
		$cookie_expire = (60 * 60 * 24 * 30);
		
        $data = array(
			'people_id'  => $params['people_id'],
			'star'       => $params['rating'],
			'ip_address' => $ip_address,
			'date'       => $date,
        );
        
	    $this->db->insert('tbl_rating', $data);
	    $insert_id = $this->db->insert_id();
		
        if($insert_id)
        {
			$this->input->set_cookie($params['people_id'], $params['rating'], $cookie_expire);
            return $insert_id;
        }
        else
        {
            return FALSE;
        }
    }
	
	
    function is_rating($params)
    {
		if( ! $this->input->cookie($params['people_id']))
		{
			$ip_address = $this->getUserIP();
			
			$this->db->select('*');
			$this->db->from('tbl_rating');
			$this->db->where('people_id', $params['people_id']);
			$this->db->where('ip_address', $ip_address);
			$this->db->where('date >= (CURDATE() - INTERVAL 30 DAY)');
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}
    }
	
	function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}
	
    function name_auto_complete($key, $flag)
    {
        $this->db->distinct();
        $this->db->select('name');      
        $this->db->from('tbl_people');     
        $this->db->or_like('LOWER(name)', $key);
        if($flag !== null) {
        	$where = "category = ".$flag;
        	$this->db->where($where);
        }
        	
        $query = $this->db->get()->result_array();
        $input = array_map("unserialize", array_unique(array_map("serialize", $query)));
        
        return $input;
    }   
	
    function view_comments($id)
    {
        $this->db->distinct();
        $this->db->select('comment, date');
        $this->db->from('tbl_comments');
		$this->db->where('people_id', $id);
        $query = $this->db->get()->result_array();
        $input = array_map("unserialize", array_unique(array_map("serialize", $query)));
        
        return $input;
    }
	
    function view_blog_comments($id)
    {
        $this->db->distinct();
        $this->db->select('comment, date');
        $this->db->from('tbl_blog_comments');
		$this->db->where('article_id', $id);
        $query = $this->db->get()->result_array();
        $input = array_map("unserialize", array_unique(array_map("serialize", $query)));
        
        return $input;
    }

	function insert_person()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			return array('status' => FALSE,'msg' => '!Sorry you have to insert person name.'); 
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Person as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Person as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	function insert_manager()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('company_name', 'Company_name', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert manager name'); 
			}
			if (!empty($error['company_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert company name'); 	
			}
			if (!empty($error['position'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert position'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['company_name'],
					'question2'       => $params['position'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 1,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Manager as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['company_name'],
				'question2'       => $params['position'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 1,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Manager as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	function insert_colleague()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('company_name', 'Company_name', 'required');
		$this->form_validation->set_rules('colleague_year', 'Colleague_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert colleague name'); 
			}
			if (!empty($error['company_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert company name'); 	
			}
			if (!empty($error['colleague_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert colleague year'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['company_name'],
					'question2'       => $params['colleague_year'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 18,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Colleague as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['company_name'],
				'question2'       => $params['colleague_year'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 18,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Colleague as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	function insert_landlord()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('landlord_year', 'Landlord_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['landlord_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert landlord year experience'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'    => $params['landlord_year'],
					'city'			  => $params['city'],
					'state'           => $params['state'],
					'category'        => 10,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Landlord as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'    => $params['landlord_year'],
				'city'			  => $params['city'],
				'state'           => $params['state'],
				'category'        => 10,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Landlord as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
	/**
	 *  insert manager
	 *  @param name, school name
	 *  @return status, messgae
	 */
	function insert_teacher()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('school_name', 'School_name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
	    
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['school_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert school name'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['school_name'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 3,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Teacher as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['school_name'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 3,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Teacher as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert founder
	 *  @param name, company_name
	 *  @return status, messgae
	 */
	function insert_founder()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('company_name', 'Company_name', 'required');	    
	    $this->form_validation->set_rules('founder_year', 'Founder_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert manager name'); 
			}
			if (!empty($error['company_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert company name'); 	
			}
			if (!empty($error['founder_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert founder year'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['company_name'],
					'question2'       => $params['founder_year'],				
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 11,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Founder as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['company_name'],
				'question2'       => $params['founder_year'],			
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 11,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Founder has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
    /**
	 *  insert investor
	 *  @param name, company_name
	 *  @return status, messgae
	 */
	function insert_investor()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('company_name', 'Company_name', 'required');
		$this->form_validation->set_rules('investor_year', 'investor_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');			
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['company_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert company name'); 	
			}
			if (!empty($error['investor_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert investor year experience'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['company_name'],
					'question2'       => $params['investor_year'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 12,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Investor as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['company_name'],
				'question2'       => $params['investor_year'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 12,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Investor has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert babysitter
	 *  @param name, contact info
	 *  @return status, messgae
	 */
	function insert_babysitter()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('babysitting_year', 'BabySitter_year', 'required');		
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert babysitter name'); 
			}
			if (!empty($error['babysitting_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert babysitting year'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'    => $params['babysitting_year'],
					'category'        => 13,
					'city'            => $params['city'],
					'state'           => $params['state'],
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "BabySitter as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'    => $params['babysitting_year'],
				'category'        => 13,
				'city'            => $params['city'],
				'state'           => $params['state'],
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "BabySitter has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert roomate
	 *  @param name, clean number
	 *  @return status, messgae
	 */
	function insert_roomate()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('roommate_year', 'Roommate_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert roomate name'); 
			}
			if (!empty($error['roommate_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert roommate year'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}

			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['roommate_year'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 14,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Roommate as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['roommate_year'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 14,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Roommate has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert boss
	 *  @param name, company name
	 *  @return status, messgae
	 */
	function insert_boss()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('company_name', 'Company_name', 'required');
		$this->form_validation->set_rules('position', 'Position', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert manager name'); 
			}
			if (!empty($error['company_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert company name'); 	
			}
			if (!empty($error['position'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert position'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}

			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['company_name'],
					'question2'       => $params['position'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 16,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Boss as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['company_name'],
				'question2'       => $params['position'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 16,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Boss has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert Agent
	 *  @param name, agent type
	 *  @return status, messgae
	 */
	function insert_agent()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('case', 'Case', 'required');
		
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert agent name'); 
			}
			if (!empty($error['case'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert case'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['case'],
					'category'        => 17,
					'city'            => $params['city'],
					'state'           => $params['state'],
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Agent as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['case'],
				'category'        => 17,
				'city'            => $params['city'],
				'state'           => $params['state'],
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Agent has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert lawyer
	 *  @param name, case type
	 *  @return status, messgae
	 */
	function insert_lawyer()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('case', 'Case', 'required');		
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert lawyer name'); 
			}
			if (!empty($error['case'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert case'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['case'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 15,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Lawyer as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['case'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 15,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Lawyer has been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	/**
	 *  insert student
	 *  @param name, school name
	 *  @return status, messgae
	 */
	function insert_student()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('school_name', 'School_name', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
	    
	if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['school_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert school name'); 	
			}
			if (!empty($error['year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert year'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['school_name'],
					'question2'       => $params['year'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 2,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Student as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];
			$resize_image = $this->resize_image($full_path, $image_width, $image_height);			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['school_name'],
				'question2'       => $params['year'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 2,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Student as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
    /**
	 *  insert student
	 *  @param name, job title
	 *  @return status, messgae
	 */
	function insert_candidate()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'job_title', 'required');
		$this->form_validation->set_rules('job_title', 'Job_title', 'required');	
	    $this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert candidate name'); 
			}
			if (!empty($error['job_title'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert candidate for what'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['job_title'],				
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 5,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Candidate as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['job_title'],				
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 5,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Candidate as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
    /**
	 *  insert student
	 *  @param name, doc type
	 *  @return status, messgae
	 */
	function insert_doctor()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('specialty', 'Specialty', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');			
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['specialty'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert doctor specialty'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
			
		}
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['specialty'],				
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 6,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Doctor  as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['specialty'],				
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 6,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Doctor as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

	 /**
	 *  insert student
	 *  @param name, first meet date
	 *  @return status, messgae
	 */
	function insert_friend()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('friend_year', 'Friend_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');			
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['friend_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert friend year relationship'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
			
		}
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['friend_year'],									
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 7,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Friend  as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['friend_year'],								
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 7,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Friend as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
     /**
	 *  insert date
	 *  @param name, friend name
	 *  @return status, messgae
	 */
	function insert_date()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('dating_year', 'dating_year', 'required');	
	    $this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert date name'); 
			}
			if (!empty($error['dating_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert dating/relationship year'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['dating_year'],				
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 8,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Date  as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['dating_year'],				
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 8,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Date as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
	 /**
	 *  insert date
	 *  @param name, address
	 *  @return status, messgae
	 */
	function insert_neighbor()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('neighbor_year', 'Neighbor_year', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert neighbor name'); 
			}
			if (!empty($error['neighbor_year'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert case'); 	
			}			
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
		}
		
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['neighbor_year'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 9,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Neighbor has been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['neighbor_year'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 9,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Neighbor as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
	/**
	 *  insert professor
	 *  @param name, unveristy name
	 *  @return status, messgae
	 */
	function insert_professor()
	{
		$params = $this->input->post();
		
		$this->form_validation->set_rules('name', 'university_name', 'required');		
		$this->form_validation->set_rules('school_name', 'School_name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');	
	
		if ($this->form_validation->run() === FALSE)
		{
			$error = $this->form_validation->error_array();
			if ( !empty($error['name']) ) {
				return array('status' => FALSE,'msg' => 'Sorry! You have to insert person name'); 
			}
			if (!empty($error['school_name'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert school name'); 	
			}
			if (!empty($error['city'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert city'); 	
			}
			if (!empty($error['state'])) {
			   return array('status' => FALSE,'msg' => 'Sorry! You have to insert state'); 	
			}
			
			
		}
		$upload_path = './assets/images';
		
		$config['upload_path']      = $upload_path;
		$config['allowed_types']    = 'jpg|jpeg|png';
		$config['overwrite']        = TRUE;
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = '10000';
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('sound_file'))
		{
			$message = $this->upload->display_errors();
			
			if($message == '<p>You did not select a file to upload.</p>')
			{
				$fields = array(
					'name'            => $params['name'],
					'question1'       => $params['school_name'],
					'city'            => $params['city'],
					'state'           => $params['state'],
					'category'        => 4,
					'picture'         => null,
					'picture_width'   => 0,
					'picture_height'  => 0,
					'date'    		  => $this->date_time(),
				);
				
				$this->db->set($fields);
				if($this->db->insert('tbl_people'))
				{
					return array('status' => TRUE,'msg' => "Professor as been add successfully\n");
				}
				else
				{
					return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
				}
			}
			else
			{
				return array('status' => FALSE,'msg' => $message); 
			}
		}
		else
		{
			$message = $this->upload->data();

			$full_path = $message['full_path'];
			$file_name = $message['file_name'];
			$image_width = $message['image_width'];
			$image_height = $message['image_height'];

			$resize_image = $this->resize_image($full_path, $image_width, $image_height);
			
			$fields = array(
				'name'            => $params['name'],
				'question1'       => $params['school_name'],
				'city'            => $params['city'],
				'state'           => $params['state'],
				'category'        => 4,
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
				'date'     => $this->date_time(),
			);
			
			
			
			$this->db->set($fields);
			if($this->db->insert('tbl_people'))
			{
				return array('status' => TRUE,'msg' => "Professor as been add successfully\n");
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}

    function resize_image($full_path, $image_width, $image_height)
    {
		
		if($image_height > $image_width)
		{
			$height = 160;
			$width = (160 / $image_height) * $image_width;
		}
		else
		{
			$width = 160;
			$height = (160 / $image_width) * $image_height;
		}
		
		$config['image_library']  = 'gd2';
		$config['source_image']   = $full_path;
		$config['create_thumb']   = FALSE;
		$config['maintain_ratio'] = FALSE;
		$config['quality']        = 100;
		
		$config['width']          = $width;
		$config['height']         = $height;
		
		$this->load->library('image_lib', $config);

		$this->image_lib->resize();
		
		return array('height' => $height, 'width' => $width);
    }
	
    function date_time()
    {
		$TimeZone = new DateTimeZone('America/Los_Angeles');
		$Date = new DateTime('0 hours', $TimeZone);
		return $Date->format('Y-m-d H:i:s');
    }
	
    function admin_email()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('tbl_users');
        return $query->row()->email;
    }
	
}