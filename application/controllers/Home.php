<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {


	public function index()
	{
		$this->load->model('file_model');
		$query = $this->file_model->get_rows();
		$data['images'] = $query;

		$this->load->view('template/header');
		$this->load->view('template/home',$data);
		$this->load->view('template/footer');
	}

	public function view_search() {
		$this->load->model('file_model');
		$title=$this->input->get('title');
		
		$data['data']=$this->file_model->search_files($title);
		$this->load->view('template/header');
		$this->load->view('search_results',$data);
		$this->load->view('template/footer');
	}


	
}
?>