<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class main extends API_Controller {

    //  Core Ajax
	public function index()
	{
        $data = [
            'root_data' => '/frontend/main/first'
        ];
		$this->load->view('frontend/main/index', $data);
    }
    
    // Ajax
    public function first(){
        $this->load->view('frontend/main/first');
    }
    
    // Error
	public function blank_404()
	{
		$this->load->view('errors/404');
    }
}
