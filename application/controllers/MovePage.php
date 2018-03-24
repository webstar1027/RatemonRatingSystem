<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MovePage extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_home');
		$this->load->model('model_people');
		$this->load->model('model_comments');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
	}       

	
   /**
	*  Redirect manager page 
	*  
	*  @return view
	*/
	public function viewManager() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->manager_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 1);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/manager',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}
    function manager_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 1));
        //echo $key;
	}
	function candidate_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 5));
        //echo $key;
	}
	function date_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 8));
        //echo $key;
	}
	function doctor_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 6));
        //echo $key;
	}
	function friend_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 7));
        //echo $key;
	}
	function neighbor_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 9));
        //echo $key;
	}
	function professor_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 4));
        //echo $key;
	}
	function student_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 2));
        //echo $key;
	}
	function teacher_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 3));
        //echo $key;
	}
	function landlord_auto_complete()
	{
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 10));
        //echo $key;
	}
   /**
	*  Insert manager
	*  
	*  @return message
	*/
	public function insert_manager() {
		$result = $this->model_home->insert_manager();
		echo json_encode($result);
	}

   /**
	*  Redirect teacher page 
	*  
	*  @return view
	*/
	public function viewTeacher() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->teacher_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 3);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/teacher',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert teacher
	*  
	*  @return message
	*/
	public function insert_teacher() {
		$result = $this->model_home->insert_teacher();
		echo json_encode($result);
	}

   /**
	*  Redirect professor page 
	*  
	*  @return view
	*/
	public function viewProfessor() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->professor_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 4);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/professor',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert professor
	*  
	*  @return message
	*/
	public function insert_professor() {
		$result = $this->model_home->insert_professor();
		echo json_encode($result);
	}

   /**
	*  Redirect student page 
	*  
	*  @return view
	*/
	public function viewStudent() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->student_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 2);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/student',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert student
	*  
	*  @return message
	*/
	public function insert_student() {
		$result = $this->model_home->insert_student();
		echo json_encode($result);
	}

   /**
	*  Redirect candidate page 
	*  
	*  @return view
	*/
	public function viewCandidate() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->candidate_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 5);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/candidate',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert candidate
	*  
	*  @return message
	*/
	public function insert_candidate() {
		$result = $this->model_home->insert_candidate();
		echo json_encode($result);
	}

   /**
	*  Redirect doctor page 
	*  
	*  @return view
	*/
	public function viewDoctor() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->doctor_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 6);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/doctor',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert doctor
	*  
	*  @return message
	*/
	public function insert_doctor() {
		$result = $this->model_home->insert_doctor();
		echo json_encode($result);
	}
   /**
	*  Redirect friend page 
	*  
	*  @return view
	*/
	public function viewFriend() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->friend_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 7);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/friend',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert friend
	*  
	*  @return message
	*/
	public function insert_friend() {
		$result = $this->model_home->insert_friend();
		echo json_encode($result);
	}
	/**
	*  Redirect date page 
	*  
	*  @return view
	*/
	public function viewDate() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->date_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 8);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/date',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert date
	*  
	*  @return message
	*/
	public function insert_date() {
		$result = $this->model_home->insert_date();
		echo json_encode($result);
	}

	/**
	*  Redirect neighbor page 
	*  
	*  @return view
	*/
	public function viewNeighbor() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->neighbor_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 9);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/neighbor',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert neighbor
	*  
	*  @return message
	*/
	public function insert_neighbor() {
		$result = $this->model_home->insert_neighbor();
		echo json_encode($result);
	}

   /**
	*  Redirect landlord page 
	*  
	*  @return view
	*/
	public function viewLandlord() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->landlord_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 10);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/landlord',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert landlord
	*  
	*  @return message
	*/
	public function insert_landlord() {
		$result = $this->model_home->insert_landlord();
		echo json_encode($result);
	}

	/**
	*  Redirect founder page 
	*  
	*  @return view
	*/
	public function viewFounder() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->founder_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 11);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/founder',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert founder
	*  
	*  @return message
	*/
	public function insert_founder() {
		$result = $this->model_home->insert_founder();
		echo json_encode($result);
	}
	function founder_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 11));
        //echo $key;
	}
	/**
	*  Redirect investor page 
	*  
	*  @return view
	*/
	public function viewInvestor() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->investor_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 12);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/investor',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert investor
	*  
	*  @return message
	*/
	public function insert_investor() {
		$result = $this->model_home->insert_investor();
		echo json_encode($result);
	}
	function investor_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 12));
        //echo $key;
	}


   /**
	*  Redirect babysitter page 
	*  
	*  @return view
	*/
	public function viewBabySitter() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->babysitter_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 13);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/babysitter',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert babysitter
	*  
	*  @return message
	*/
	public function insert_babysitter() {
		$result = $this->model_home->insert_babysitter();
		echo json_encode($result);
	}
	function babysitter_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 13));
        //echo $key;
	}
	
   /**
	*  Redirect roommate page 
	*  
	*  @return view
	*/
	public function viewRoomate() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->roomate_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 14);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/roomate',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert roommate
	*  
	*  @return message
	*/
	public function insert_roomate() {
		$result = $this->model_home->insert_roomate();
		echo json_encode($result);
	}
	function roomate_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 14));
        //echo $key;
	}
    
   /**
	*  Redirect lawyer page 
	*  
	*  @return view
	*/
	public function viewLawyer() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->lawyer_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 15);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/lawyer',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert lawyer
	*  
	*  @return message
	*/
	public function insert_lawyer() {
		$result = $this->model_home->insert_lawyer();
		echo json_encode($result);
	}
	function lawyer_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 15));
        //echo $key;
	}


	/**
	*  Redirect boss page 
	*  
	*  @return view
	*/
	public function viewBoss() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->boss_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 16);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/boss',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert boss
	*  
	*  @return message
	*/
	public function insert_boss() {
		$result = $this->model_home->insert_boss();
		echo json_encode($result);
	}
	function boss_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 16));
        //echo $key;
	}

	/**
	*  Redirect agent page 
	*  
	*  @return view
	*/
	public function viewAgent() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->agent_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 17);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/agent',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert agent
	*  
	*  @return message
	*/
	public function insert_agent() {
		$result = $this->model_home->insert_agent();
		echo json_encode($result);
	}
	function agent_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 17));
        //echo $key;
	}
   /**
	*  Redirect colleague page 
	*  
	*  @return view
	*/
	public function viewColleague() {
		$search_name = $this->input->post('search_name');
		if(empty($search_name))
		{
			$data['people_data'] = $this->model_people->colleague_data();
		}
		else
		{
			$data['people_data'] = $this->model_people->search_name($search_name, $flag = 18);
		}
		
		if ( ! $this->agent->is_mobile())
		{
			$this->load->view('pages/colleague',$data);
		}
		else 
		{
			$this->load->view('home_phone',$data);
		}
	  
	}

   /**
	*  Insert colleague
	*  
	*  @return message
	*/
	public function insert_colleague() {
		$result = $this->model_home->insert_colleague();
		echo json_encode($result);
	}
	function colleague_auto_complete() {
            //ini_set('display_errors', 1);
        $key = $this->input->post('key');
        echo json_encode($this->model_home->name_auto_complete($key, $flag = 18));
        //echo $key;
	}
	
}