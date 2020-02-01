<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class migration extends API_Controller {

    public function __construct(){
        parent::__construct();
    }

	public function index()
	{
		header("Access-Control-Allow-Origin: *");

		// API Configuration
		$this->_apiConfig([
			'methods' => ['GET'],
        ]);

        $result = [
            '1. ' => base_url('/migration/connection'),
            '2. ' => base_url('/migration/generate'),
            '3. ' => base_url('/migration/crud_generator'),
            '4. ' => 'Happy Code',
        ];

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => $result,
			],
		200);
	}

	public function connection()
	{
        $this->load->database();
		header("Access-Control-Allow-Origin: *");

		// API Configuration
		$this->_apiConfig([
			'methods' => ['GET'],
        ]);

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => "Api Oke",
			],
		200);
	}

	public function generate()
	{
        $this->load->database();
		header("Access-Control-Allow-Origin: *");

		$sql = $this->db->query(
			"
			CREATE TABLE `tm_data` (
			  `child_id` int NOT NULL AUTO_INCREMENT,
			  `child_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
			  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `created_by` int NOT NULL DEFAULT '".date('dmY')."',
			  `updated_at` datetime NOT NULL,
			  `updated_by` int NOT NULL,
			  `deleted_at` datetime NOT NULL,
			  `deleted_by` int NOT NULL,
			  PRIMARY KEY (`child_id`),
			  CONSTRAINT `tm_data_chk_1` CHECK (json_valid(`child_value`))
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1"
		);
		if($sql){
			$sql_2 = $this->db->query(
				"
				CREATE TABLE `tm_attribute` (
				`attribute_id` int NOT NULL AUTO_INCREMENT,
				`attribute_data` longtext NOT NULL,
				`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`created_by` int NOT NULL DEFAULT '".date('dmY')."',
				`updated_at` datetime NOT NULL,
				`updated_by` int NOT NULL,
				`deleted_at` datetime NOT NULL,
				`deleted_by` int NOT NULL,
				PRIMARY KEY (`attribute_id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1"
			);
			if($sql_2){
				$result = "Generating table tm_data & tm_attribute Okay";
			}else{
				$result = "Generating table tm_data Okay";
			}
		}else{
			$result = "Generating table tm_data Not Okay";
		}

		// API Configuration
		$this->_apiConfig([
			'methods' => ['GET'],
        ]);

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => $result,
			],
		200);
	}

	public function crud_generator()
	{
        $this->load->database();
		header("Access-Control-Allow-Origin: *");

		// API Configuration
		$this->_apiConfig([
			'methods' => ['GET'],
        ]);

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => "Api Oke",
			],
		200);
	}
}
