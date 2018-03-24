<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_feedback extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    function feedback_data()
    {
        $this->db->select('*');
		$this->db->from('tbl_feedback');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function remove_feedback($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_feedback');
        return TRUE;
    }

}