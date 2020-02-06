<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class main extends API_Controller {

	public function index()
	{
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

	public function category()
	{
        $this->load->database();
		header("Access-Control-Allow-Origin: *");

		// API Configuration
		$this->_apiConfig([
			'methods' => ['GET'],
        ]);
        
        $query = $this->db->query(
        "SELECT
            child_id as id,
            JSON_UNQUOTE(
                JSON_EXTRACT(child_value, \"$.k2\")
            ) as text,
            JSON_UNQUOTE(
                JSON_EXTRACT(child_value, \"$.k1\")
            ) as url
        FROM
            tm_data 
        WHERE
            JSON_EXTRACT(child_value, \"$.k0\") = 'category' and
            deleted_by = '0'
        "
        );

		$result = $query->result_array();

        if($result){
            $status = true;
            $json = $result;
        }else{
            $status = false;
            $json = "Failed Catching Data";
        }

        // return data
		$this->api_return(
			[
				'status' => $status,
				"results" => $json,
			],
		200);
    }
}
