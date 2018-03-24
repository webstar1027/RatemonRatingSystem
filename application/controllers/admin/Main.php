<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Dashboard_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		$this->load->model('model_people');
		$this->load->model('model_comments');
	}
        
	public function index()
	{
		$data['total_comments'] = $this->model_comments->total_comments();
		$data['total_people'] = $this->model_people->total_people();
		$data['total_rating'] = $this->model_people->total_rating();
		
		$data['last_comments'] = $this->model_comments->last_comments();

        $this->load->view('admin/header');
        $this->load->view('admin/main' , $data);
        $this->load->view('admin/footer');

	}
}