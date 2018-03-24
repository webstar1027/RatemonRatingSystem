<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model
{
    public function __construct()
    {
            parent::__construct();
    }

    function login($username = FALSE, $password = FALSE)
    {
		
        if($username != FALSE && $password != FALSE)
        {
            $username = $this->security->xss_clean($username);
            $password = $this->security->xss_clean($password);

            $query=$this->db->query("SELECT id,username,full_name,password,active FROM tbl_users WHERE username='".$username."' LIMIT 1");
            $user_data = $query->row();

            if($user_data)
            {
                if (password_verify($password, $user_data->password))
                {
                    return $user_data;
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
            return FALSE;
        }
    }

    function set_session($user_data)
    {
        $session_data = array(
            'id' => $user_data->id,
            'username' => $user_data->username,
            'full_name' => $user_data->full_name,
            'logged_in' => TRUE,
            );

        $this->session->set_userdata($session_data);
    }
    
    function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
    
    function set_logged_time($id)
    {
        $this->db->query("UPDATE tbl_users SET last_login=UNIX_TIMESTAMP() WHERE id=".$id);
    }

}