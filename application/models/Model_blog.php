<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_blog extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	function new_article($params)
	{
		
		$slg = str_replace(" ", "-", $params['topic']);
		$slg = strtolower($slg);
		$slg = preg_replace('/[^A-Za-z0-9\-]/,()', '', $slg);
		
		
        $data = array(
			'topic'   => $params['topic'],
			'content' => htmlentities($params['content']),
			'slg' 	  => $slg,
			'date'    => $this->date_time(),
        );
		
	    $this->db->insert('tbl_blog', $data);
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
	
	function update_article($params)
	{
        $data = array(
			'topic'    => $params['topic'],
			'content'  => htmlentities($params['content']),
        );
        
        $this->db->where('id', $params['article_id']);
        $this->db->update('tbl_blog', $data);
        
        if($this->db->affected_rows())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}

    function article_data($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_blog');
        $row = $query->row_array();
		
        return array('topic' => $row['topic'], 'content' => htmlspecialchars_decode($row['content']));
    }
    
    function all_articles_data($slg = FALSE)
    {
        $this->db->select('a.* , (SELECT comment FROM tbl_blog_comments d WHERE a.id = d.article_id ORDER BY `date` DESC LIMIT 1) last_comment');
		$this->db->from('tbl_blog a');
		if($slg)
		{
			$this->db->where('slg', $slg);
		}
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function delete_article($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_blog');
        return TRUE;
    }
	
    function date_time()
    {
		$TimeZone = new DateTimeZone('America/Los_Angeles');
		$Date = new DateTime('0 hours', $TimeZone);
		return $Date->format('Y-m-d H:i:s');
    }

}