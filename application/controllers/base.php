<?php
class Base extends CI_Controller {
	
	function index() 
	{
		// Loader helper for getting stats XML; apply to data
		$this->load->helper('honxml');
		$clanmembers = clanRoster('HEY');
		$data['stats'] = honUserStats($clanmembers);
		
		$this->load->model('base_model');
		$data['records'] = $this->base_model->getAll();
		
		$this->load->view('index', $data);
	}
}