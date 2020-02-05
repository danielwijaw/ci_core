<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class main extends API_Controller {

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
            '1. ' => base_url('/migration/main/connection'),
            '2. ' => base_url('/migration/main/generate'),
            '3. ' => base_url('/migration/main/crud_generator'),
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
				"result" => "Connection To Database Oke",
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
		if(!isset($_GET['lets_go'])){
			echo "<div align=\"center\">";
			echo "<h3>CRUD GENERATOR LIT VERSION</h3>";
			echo "<form method=\"GET\" action=\"".base_url('/migration/main/crud_generator')."\">";
			echo "<input type=\"hidden\" name=\"lets_go\" value=\"true\">";
			echo "<input type=\"text\" name=\"category\" placeholder=\"Masukan Jenis Category\">";
			echo "<br/><br/>";
			echo "<input type=\"number\" name=\"key\" placeholder=\"Masukan Jumlah Key\">";
			echo "<br/><br/>";
			echo "<input type=\"submit\" value=\"Generate\">";
			echo "<div>";
		}else{
			$this->load->database();
			header("Access-Control-Allow-Origin: *");

			// INSERTING DATA
			$insert['k0'] = 'category';
			$insert['k1'] = strtolower($_GET['category']);
			$insert['k1'] = str_replace(" ","_",$insert['k1']);
			$insert['k2'] = $_GET['category'];

			$data = array(
				'child_value' 	=> json_encode($insert),
				'created_by' 	=> '777999777'
			);
			
			$insert_category = $this->db->insert('tm_data', $data);

			if($insert_category){
				$return = "Success Insert Category Menu First on ".$_GET['category']." And Doing Sample Data";

				// INSERTING DATA SAMPLE
				$insert_data['k0']		= $insert['k1'];
				$insert_data['k0_text']	= $_GET['category'];
				for($x=1 ;$x <= $_GET['key']; $x++){
					// echo $x;
					$insert_data["k".$x] 			= "01";
					$insert_data["k".$x."_text"] 	= "01";
				}

				$data_sample = array(
					'child_value' 	=> json_encode($insert_data),
					'created_by' 	=> '777999777'
				);
				
				$insert_sample = $this->db->insert('tm_data', $data_sample);

				if($insert_sample){
					$return = "Success Insert Category Menu First on ".$_GET['category'].", Success Insert Sample Data And Doing Generate File";

					// Creating Directory Views
					$mkdir_views = mkdir(APPPATH."/views/".$insert_data['k0'], 01777);
					chmod(APPPATH."/views/".$insert_data['k0'], 01777);

					if($mkdir_views){
						$return = 'Create Directory Views Done';

						// Created Controller Frontend
						$string = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ".$insert_data['k0']." extends API_Controller {

	//  Core Ajax
	public function index()
	{
		\$data = [
			'root_data' => '/frontend/".$insert_data['k0']."/main'
		];
		\$this->load->view('frontend/".$insert_data['k0']."/index', \$data);
	}

	public function create()
	{
		\$data = [
			'root_data' => '/frontend/".$insert_data['k0']."/created'
		];
		\$this->load->view('frontend/".$insert_data['k0']."/index', \$data);
	}

	public function update()
	{
		\$data = [
			'root_data' => '/frontend/".$insert_data['k0']."/updated'
		];
		\$this->load->view('frontend/".$insert_data['k0']."/index', \$data);
	}
	
	// Ajax
	public function main(){
		\$this->load->view('frontend/".$insert_data['k0']."/main');
	}

	public function created(){
		\$this->load->view('frontend/".$insert_data['k0']."/create');
	}

	public function updated(){
		\$this->load->view('frontend/".$insert_data['k0']."/update');
	}

}";
						$my_file = APPPATH."/controllers/frontend/".ucwords($insert_data['k0']).".php";
						$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
						fwrite($handle, $string);
						$file_controller_frontend = fclose($handle);
						chmod($my_file, 01777);
						if($file_controller_frontend){
							$return = 'Create Frontend Controllers Done';

							// Created Controller Backend
							$string = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ".$insert_data['k0']." extends API_Controller {

    function __contruct(){
        parent::__construct();
        \$this->load->database();
    }

	public function index(\$category = '".$insert_data['k0']."')
	{
		\$this->load->helper('api_helper');
		header(\"Access-Control-Allow-Origin: *\");

		// API Configuration
		\$this->_apiConfig([
			'methods' => ['GET'],
        ]);

        if(isset(\$_GET['search']['value'])){
            \$search = \"and JSON_SEARCH(UPPER(tm_data.child_value), 'all', UPPER('%\".\$_GET['search']['value'].\"%')) IS NOT NULL\";
        }else{
            \$search = \"\";
        }

        \$query_count = \$this->db->query(
            \"SELECT 
                count(tm_data.child_id) as recordsTotal
            FROM
                tm_data
            WHERE
                JSON_EXTRACT(tm_data.child_value, \\\"\$.k0\\\") = '\".\$category.\"' and
                deleted_by = '0'
                \".\$search.\"
            \"
        );

        \$result_count = \$query_count->row_array();

        \$query = \$this->db->query(
        \"SELECT
			tm_data.child_id as id,";
			for($x=1 ;$x <= $_GET['key']; $x++){
				$string .="
				JSON_UNQUOTE(
					JSON_EXTRACT(tm_data.child_value, \\\"\$.k".$x."\\\")
				) as k".$x.",
				";
			}
			$string .="`text`
        FROM
            tm_data 
        WHERE
            JSON_EXTRACT(tm_data.child_value, \\\"\$.k0\\\") = '\".\$category.\"' and
            tm_data.deleted_by = '0'
            \".\$search.\"
        LIMIT 
            \".\$_GET['length'].\"
        OFFSET
            \".\$_GET['start'].\"
        \"
        );

		\$result = \$query->result_array();

        foreach(\$result as \$key => \$value){
            \$datatables[\$key] = [
                ";
			for($x=1 ;$x <= $_GET['key']; $x++){
				$string .="\$value['k".$x."'],";
			}
			$string .="
			\"<a href=\\\"\".base_url('/frontend/".$insert_data['k0']."/update/'.my_simple_crypt(\$value['id'],'e')).\"\\\"<button class=\\\"btn btn-primary btn-sm\\\">Edit</button></a> <a onclick=\\\"return confirm('Anda Yakin Menghapus Data \".\$value['k1'].\"?')\\\" href=\\\"\".base_url('/backend/".$insert_data['k0']."/delete/'.my_simple_crypt(\$value['id'],'e')).\"\\\"<button class=\\\"btn btn-primary btn-sm\\\">Delete</button></a>\"
            ];
        }

        if(\$result){
            \$status = true;
            \$json = \$datatables;
            \$recordsTotal = \$result_count['recordsTotal'];
        }else{
            \$status = false;
            \$json[0] = [\"0\",\"Failed Catching Data\"];
            \$recordsTotal = \"0\";
        }

        // return data
		\$this->api_return(
			[
                'draw'  => \$_GET['draw'],
				'status' => \$status,
                'recordsTotal' => \$recordsTotal,
                'recordsFiltered' => \$recordsTotal,
                'data'  => \$json
			],
		200);
	}

}";

						$my_file = APPPATH."/controllers/backend/".ucwords($insert_data['k0']).".php";
						$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
						fwrite($handle, $string);
						$file_controller_frontend = fclose($handle);
						chmod($my_file, 01777);

						}else{
							$return = 'Create Frontend Controllers Failed';
						}
					}else{
						$return = 'Create Directory Views Failed';
					}
				}else{
					$return = "Success Insert Category Menu First on ".$_GET['category']." And Failed Insert Sample Data";
				}
			}else{
				$return = "Failed Insert Category Menu First on ".$_GET['category'];
			}

			// API Configuration
			$this->_apiConfig([
				'methods' => ['GET'],
			]);

			// return data
			$this->api_return(
				[
					'status' => true,
					"result" => $return,
				],
			200);
		}
	}
}
