<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_profile extends CI_Model
{
    public function __construct()
    {
            parent::__construct();
    }
    
    function update_password($password)
    {
        $user_id = $this->session->id;
        
        $options = ['cost' => 11, 'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),];
        $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);
        
        $this->db->set(array('password'   => $hash_password));
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
        
        return TRUE;
    }
    
    function get_user_info()
    {
        $user_id = $this->session->id;
        
        $this->db->where('id', $user_id);
        $query = $this->db->get('tbl_users');
        $row = $query->row();
        return $row;
    }
    
    function update_name($full_name)
    {
        $user_id = $this->session->id;
        
        $this->db->set(array('full_name'   => $full_name));
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
        
        return TRUE;
    }
    
    function update_email($email)
    {
        $user_id = $this->session->id;
        
        $this->db->set(array('email'   => $email));
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
        
        return TRUE;
    }
    
}