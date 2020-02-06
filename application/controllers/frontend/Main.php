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

    public function admin()
	{
        $data = [
            'root_data' => '/frontend/main/administrator'
        ];
		$this->load->view('frontend/main/base', $data);
    }
    
    // Ajax
    public function first(){
        $this->load->view('frontend/main/main');
    }

    public function administrator(){
        $this->load->view('frontend/main/admin');
    }

    public function sidebar(){
        $this->load->view('frontend/main/sidebar');
    }
    
    public function topbar(){
        $this->load->view('frontend/main/topbar');
    }
    
    // Error
	public function blank_404()
	{
		$this->load->view('errors/404');
    }
}
