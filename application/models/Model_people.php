<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_people extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('upload');
    }

	function insert_people()
	{
		$params = $this->input->post();
		
		if(empty($params['name']))
		{
			return array('status' => FALSE,'msg' => 'Sorry you have to insert people name.');
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
			return array('status' => FALSE,'msg' => $message); 
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
				return array('status' => TRUE,'msg' => "People add successfully\n" );
			}
			else
			{
				return array('status' => FALSE,'msg' => "There was a problem while uploading\n" );
			}
		}
	}
	
	function update_people()
	{
		$params = $this->input->post();

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
				$data = array(
					'name'            => $params['name'],
				);
				
				$this->db->where('id', $params['people_id']);
				if($this->db->update('tbl_people', $data))
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
				return FALSE; 
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

			$data = array(
				'name'            => $params['name'],
				'picture'         => $message['file_name'],
				'picture_width'   => $resize_image['width'],
				'picture_height'  => $resize_image['height'],
			);
			
			$this->db->where('id', $params['people_id']);
			$this->db->update('tbl_people', $data);
			
			if($this->db->affected_rows())
			{
				return TRUE;
			}
			else
			{
				return FALSE;
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

    function get_people_data($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_people');
        $row = $query->row();
        return $row;
    }
    function fetch_peoples($limit, $start){
    	$this->db->limit($limit, $start);
    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$result = $this->db->get()->result_array();

		if (count($result) > 0){
			return $result;
		}
        return false;

    }
    function people_data()
    {
        $this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');
        $result = $this->db->get()->result_array();
        return $result;
    }

    
    function manager_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 1');
        $result = $this->db->get()->result_array();
        return $result;

    }

    function colleague_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 18');
        $result = $this->db->get()->result_array();
        return $result;

    }

    function teacher_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 3');
        $result = $this->db->get()->result_array();
        return $result;

    }

    function professor_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 4');
        $result = $this->db->get()->result_array();
        return $result;

    }
	function student_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 2');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function lawyer_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 15');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function agent_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 17');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function boss_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 16');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function roomate_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 14');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function friend_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 7');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function neighbor_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 9');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function landlord_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 10');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function date_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 8');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function doctor_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 6');
        $result = $this->db->get()->result_array();
        return $result;

    }

    function founder_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 11');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function investor_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 12');
        $result = $this->db->get()->result_array();
        return $result;

    }
     function babysitter_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 13');
        $result = $this->db->get()->result_array();
        return $result;

    }
    function candidate_data() {

    	$this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');		
		$this->db->where('category = 5');
        $result = $this->db->get()->result_array();
        return $result;

    }
	
    function search_name($name, $flag)
    {
        $this->db->select('a.*, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 1) star_1, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 2) star_2, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 3) star_3, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 4) star_4, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id AND star = 5) star_5, (SELECT COUNT(id) FROM tbl_comments b WHERE a.id = b.people_id) total_comments, (SELECT COUNT(id) FROM tbl_rating c WHERE a.id = c.people_id) total_rating, (SELECT comment FROM tbl_comments d WHERE a.id = d.people_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_people a');
		$this->db->or_like('LOWER(name)', strtolower($name));
		if($flag != null) {
			$this->db->where('category ='.$flag);
		}
        $result = $this->db->get()->result_array();
        return $result;
    }  
	
    function total_people()
    {
        $this->db->select('count(id) as total_people');
		$this->db->from('tbl_people');
        $result = $this->db->get()->row_array();
        return $result['total_people'];
    }
	
    function total_rating()
    {
        $this->db->select('count(id) as total_rating');
		$this->db->from('tbl_rating');
        $result = $this->db->get()->row_array();
        return $result['total_rating'];
    }
	
    
    function people_data_main()
    {
        $user_id = $this->session->id;
        
        if($user_id == 1 OR $user_id == 2 )
        {
            $query = $this->db->query("SELECT *, (SELECT COUNT(id) FROM cd_clients A WHERE A.add_by = B.id) total_clients FROM cd_users B;");
        }
        else
        {
            $query = $this->db->query("SELECT *, (SELECT COUNT(id) FROM cd_clients A WHERE A.add_by = B.id) total_clients FROM cd_users B WHERE B.id = ".$user_id."");
        }

        $result = $query->result_array();
        return $result;
    }
    
    function remove_people($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_people');
        return TRUE;
    }
	
    function calculat_rating()
    {
        $query = $this->db->query("SELECT COUNT(star) as rating_number FROM tbl_rating GROUP BY star");
        $data = $query->result_array();
    }
	
    function date_time()
    {
		$TimeZone = new DateTimeZone('America/Los_Angeles');
		$Date = new DateTime('0 hours', $TimeZone);
		return $Date->format('Y-m-d H:i:s');
    }

}