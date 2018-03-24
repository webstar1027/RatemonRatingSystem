<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_blog_comments extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function update_comment($params)
    {
        $data = array(
        'comment'    => $params['comment'],
        );
        
        $this->db->where('id', $params['comment_id']);
        $this->db->update('tbl_blog_comments', $data);
        
        if($this->db->affected_rows())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function comments_data()
    {
        $this->db->select('a.*, b.topic');
		$this->db->from('tbl_blog_comments a');
		$this->db->join('tbl_blog b', 'b.id = a.article_id', 'left');
        $result = $this->db->get()->result_array();
        return $result;
    }
	
    function last_comments()
    {
        $this->db->select('a.*, b.topic');
		$this->db->from('tbl_blog_comments a');
		$this->db->join('tbl_blog b', 'b.id = a.article_id', 'left');
		$this->db->order_by('id', 'ASC');
		$this->db->limit(10);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function remove_comment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_blog_comments');
        return TRUE;
    }
	
    function get_comment_data($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_blog_comments');
        $row = $query->row();
        return $row;
    }
	
    function date_time()
    {
		$TimeZone = new DateTimeZone('America/Los_Angeles');
		$Date = new DateTime('0 hours', $TimeZone);
		return $Date->format('Y-m-d H:i:s');
    }

}