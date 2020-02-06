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
					// $insert_data["k".$x."_text"] 	= "01";
				}

				$data_sample = array(
					'child_value' 	=> json_encode($insert_data),
					'created_by' 	=> '777999777'
				);
				
				// $insert_sample = $this->db->insert('tm_data', $data_sample);
				$insert_sample = true;

				if($insert_sample){
					$return = "Success Insert Category Menu First on ".$_GET['category'].", Success Insert Sample Data And Doing Generate File";

					// Creating Directory Views
					$mkdir_views = mkdir(APPPATH."/views/frontend/".$insert_data['k0'], 01777);
					chmod(APPPATH."/views/frontend/".$insert_data['k0'], 01777);

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

	public function update(\$id)
	{
		\$data = [
			'root_data' => '/frontend/".$insert_data['k0']."/updated/'.\$id
		];
		\$this->load->view('frontend/".$insert_data['k0']."/index', \$data);
	}
	
	// Ajax
	public function main(){
		\$data = [
			'controller' => \$this
		];
		\$this->load->view('frontend/".$insert_data['k0']."/main', \$data);
	}

	public function created(){
		\$data = [
			'controller' => \$this
		];
		\$this->load->view('frontend/".$insert_data['k0']."/create', \$data);
	}

	public function updated(\$id){
		\$data = [
			'controller' => \$this
		];
		\$this->load->view('frontend/".$insert_data['k0']."/update', \$data);
	}

	// Configuration Name Key
	public function name_key(\$key){";
		for($x=1 ;$x <= $_GET['key']; $x++){
			$string .= "
		if(\$key == 'k".$x."')
		{
			\$key = 'k".$x."';
		}";
		}
		$string .="

		return \$key;
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

    function __construct(){
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
		
		if(isset(\$_GET['draw'])){
            \$_GET['draw'] = \$_GET['draw'];
        }else{
            \$_GET['draw'] = \"\";
        }

        if(isset(\$_GET['start'])){
            \$_GET['start'] = \$_GET['start'];
        }else{
            \$_GET['start'] = \"0\";
        }

        if(isset(\$_GET['length'])){
            \$_GET['length'] = \$_GET['length'];
        }else{
            \$_GET['length'] = \"10\";
        }

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
			$string .="'text'
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
            \$json[0] = [\"0\",";for($x=1 ;$x <= $_GET['key']; $x++){ $string .="\"Failed Catching Data\","; }$string .="\"Failed Catching Data\"];
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

	public function delete(\$id)
	{
        \$this->load->helper('api_helper');
        \$this->load->helper('cookie');
		header(\"Access-Control-Allow-Origin: *\");

		// API Configuration
		\$this->_apiConfig([
			'methods' => ['GET'],
        ]);
        
        \$cookie = get_cookie(\"cookielogin\");
		\$cookie = JSON_DECODE(\$cookie, true);
		
		if(!isset(\$cookie)){
			\$cookie = [
				'id' => 'Z3A1L2w2ZlA0bEtmUEgrS0NPbmZUZz09'
			];
		}

        \$this->db->set('deleted_by', my_simple_crypt(\$cookie['id'], 'd'));
        \$this->db->set('deleted_at', date('Y-m-d H:i:s'));
        \$this->db->where('child_id', my_simple_crypt(\$id,'d'));
        \$result = \$this->db->update('tm_data');

        if(\$result){
            \$status = \"Delete Data Success\";
            \$json = \$result;
            redirect('/frontend/".$insert_data['k0']."/index');
        }else{
            \$status = false;
            \$json = \"Failed Delete Data\";
        }

        // return data
		\$this->api_return(
			[
				'status' => \$status,
				\"results\" => \$json,
			],
		200);
	}
	
	public function create(){
        header(\"Access-Control-Allow-Origin: *\");
        \$this->load->helper('cookie');
        \$this->load->helper('api_helper');

		// API Configuration
		\$this->_apiConfig([
			'methods' => ['POST'],
        ]);

        \$cookie = get_cookie(\"cookielogin\");
		\$cookie = JSON_DECODE(\$cookie, true);
		
		if(!isset(\$cookie)){
			\$cookie = [
				'id' => 'Z3A1L2w2ZlA0bEtmUEgrS0NPbmZUZz09'
			];
		}

        \$data = array(
            'child_value' => JSON_ENCODE(\$_POST['result']),
            'created_by' => my_simple_crypt(\$cookie['id'], 'd')
        );
    
        \$insert = \$this->db->insert('tm_data', \$data);

        if(\$insert){
            \$status = true;
            \$json = \"Success Insert Data\";
            redirect('/frontend/".$insert_data['k0']."/index');
        }else{
            \$status = false;
            \$json = \"Failed Inserting Data\";
        }

        // return data
		\$this->api_return(
			[
				'status' => \$status,
				\"results\" => \$json,
			],
		200);
	}
	
	public function update(\$id){
        header(\"Access-Control-Allow-Origin: *\");
        \$this->load->helper('cookie');
        \$this->load->helper('api_helper');

		// API Configuration
		\$this->_apiConfig([
			'methods' => ['POST'],
        ]);

        \$cookie = get_cookie(\"cookielogin\");
		\$cookie = JSON_DECODE(\$cookie, true);
		
		if(!isset(\$cookie)){
			\$cookie = [
				'id' => 'Z3A1L2w2ZlA0bEtmUEgrS0NPbmZUZz09'
			];
		}

        \$data = array(
            'child_value' => JSON_ENCODE(\$_POST['result']),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => my_simple_crypt(\$cookie['id'], 'd')
        );
    
        \$this->db->where('child_id', my_simple_crypt(\$id, 'd'));
        \$update = \$this->db->update('tm_data', \$data);

        if(\$update){
            \$status = true;
            \$json = \"Success Update Data\";
            redirect('/frontend/".$insert_data['k0']."/index');
        }else{
            \$status = false;
            \$json = \"Failed Update Data\";
        }

        // return data
		\$this->api_return(
			[
				'status' => \$status,
				\"results\" => \$json,
			],
		200);
	}
	
	public function get_id(\$id)
	{
        \$this->load->helper('api_helper');
        header(\"Access-Control-Allow-Origin: *\");

		// API Configuration
		\$this->_apiConfig([
			'methods' => ['GET'],
		]);
		
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
				$string .="'text'
			FROM
				tm_data 
			WHERE
				tm_data.child_id = '\".my_simple_crypt(\$id, 'd').\"' and
				tm_data.deleted_by = '0'
			\"
			);
	
			\$result = \$query->row_array();

			\$result['id'] = my_simple_crypt(\$result['id'], 'e');
			
			if(\$result){
				\$status = true;
				\$json = \$result;
			}else{
				\$status = false;
				\$json = \"Failed Catching Data\";
			}
	
			// return data
			\$this->api_return(
				[
					'status' => \$status,
					\"results\" => \$json,
				],
			200);
	}

}";

						$my_file = APPPATH."/controllers/backend/".ucwords($insert_data['k0']).".php";
						$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
						fwrite($handle, $string);
						$file_controller_backend = fclose($handle);
						chmod($my_file, 01777);

							if($file_controller_backend){
								$return = 'Create Backend Controllers Done';

								// Created Base Index
								$string = "<!DOCTYPE html>
<html lang=\"en\">

<head>

  <meta charset=\"utf-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

  <title><?php echo \$this->config->item('title_aps'); ?></title>

  <!-- Custom fonts for this template-->
  <link href=\"<?php echo base_url() ?>public/vendor/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">
  <link href=\"<?php echo base_url() ?>public/css/fontapis.css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i\" rel=\"stylesheet\">
  <style>
      .ajaxloadingdata {
        color: white;
        font-weight: bold;
      }
  </style>
  <!-- Custom styles for this template-->
  <link href=\"<?php echo base_url() ?>public/css/sb-admin-2.min.css\" rel=\"stylesheet\">
  <script src=\"<?php echo base_url() ?>public/vendor/jquery/jquery.min.js\"></script>
</head>

<body id=\"page-top\">

  <!-- Page Wrapper -->
  <div id=\"wrapper\">

    <ul id=\"accordionSidebar\" class=\"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion\"></ul>

    <!-- Content Wrapper -->
    <div id=\"content-wrapper\" class=\"d-flex flex-column\">

      <!-- Main Content -->
      <div id=\"content\">
        <div id=\"topbar\"></div>
        <div id=\"root_data\"></div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class=\"sticky-footer bg-white\">
        <div class=\"container my-auto\">
          <div class=\"copyright text-center my-auto\">
            <span>&copy; <?php echo \$this->config->item('title_aps'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
  <script>
    ajax(\"<?php echo base_url(\"/\".\$root_data) ?>\",\"#root_data\");
    ajax(\"<?php echo base_url('/frontend/main/sidebar') ?>\",\"#accordionSidebar\");
    ajax(\"<?php echo base_url('/frontend/main/topbar') ?>\",\"#topbar\");
    function ajax(url, div){
        \$(div).html(\"<p class='ajaxloadingdata'>LOADING DATA PLEASE WAIT</p>\");
        \$.ajax({
            url: url,
            contentType: false,
            cache: true,
            processData: false,
            success: function(data) {
                \$(div).html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                \$(div).html(\"<p class='ajaxloadingdata'>Error Catching Data</p>\");
                \$(\"#catching_error\").html(XMLHttpRequest.responseText); 
                if (XMLHttpRequest.status == 0) {
                alert(' Check Your Network.');
                } else if (XMLHttpRequest.status == 404) {
                alert('Requested URL not found.');
                } else if (XMLHttpRequest.status == 500) {
                alert('Internel Server Error.');
                }  else {
                alert('Unknow Error.\\\n' + XMLHttpRequest.responseText);
                } 
            }
        });
    }
  </script>
</body>

</html>
";

							$my_file = APPPATH."views/frontend/".$insert_data['k0']."/index.php";
							$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
							fwrite($handle, $string);
							$file_index_frontend = fclose($handle);
							chmod($my_file, 01777);

							if($file_index_frontend){
								$return = 'Create View Index Done';

								// Created Base Main
								$string = "<link href=\"<?php echo base_url() ?>public/css/datatables.min.css\" rel=\"stylesheet\" type=\"text/css\">
<script src=\"<?php echo base_url() ?>public/js/datatables.min.js\"></script>
<div class=\"col-xl-12 col-lg-12\">
    <div class=\"card shadow mb-4\">
        <!-- Card Header -->
        <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\">
            <h6 class=\"m-0 font-weight-bold text-primary\">".$insert_data['k0_text']."</h6>
        </div>
        <!-- Card Body -->
        <div class=\"card-body\">
            <a href=\"<?php echo base_url('/frontend/".$insert_data['k0']."/create') ?>\">
                <button type=\"button\" class=\"btn btn-primary btn-sm\">Tambah Data</button>
            </a>
            <br/><br/>
            <table id=\"datatables_".$insert_data['k0']."\" class=\"display\" style=\"width:100%\">
                <thead>
                    <tr>
						<th>Text</th>";
						for($x=1 ;$x <= $_GET['key']; $x++){
							$string .="
						<th><?php echo \$controller->name_key('k".$x."') ?></th>
							";
						}
						$string .="
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Text</th>";
						for($x=1 ;$x <= $_GET['key']; $x++){
							$string .="
						<th><?php echo \$controller->name_key('k".$x."') ?></th>
							";
						}
						$string .="
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
\$(document).ready(function() {
    \$('#datatables_".$insert_data['k0']."').DataTable({
        \"processing\": true,
        \"serverSide\": true,
        \"ajax\"      : \"<?php echo base_url('backend/".$insert_data['k0']."/') ?>\"
    });
} );
</script>";

								$my_file = APPPATH."views/frontend/".$insert_data['k0']."/main.php";
								$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
								fwrite($handle, $string);
								$file_main_frontend = fclose($handle);
								chmod($my_file, 01777);

								if($file_main_frontend){
									$return = 'Create View Main Done';
	
									// Created Base Creatte
									$string = "<div class=\"col-xl-12 col-lg-12\">
    <div class=\"card shadow mb-4\">
        <!-- Card Header -->
        <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Tambah Data ".$insert_data['k0_text']."</h6>
        </div>
        <!-- Card Body -->
        <div class=\"card-body\">
            <div class=\"col-md-12\">
                <form method=\"POST\" action=\"<?php echo base_url('/backend/".$insert_data['k0']."/create') ?>\">   
                    <input type=\"hidden\" name=\"<?php echo \$this->security->get_csrf_token_name();?>\" value=\"<?php echo \$this->security->get_csrf_hash();?>\">
                    <input type=\"hidden\" class=\"form-control\" name=\"result[k0]\" value=\"".$insert_data['k0']."\" required>
                    <input type=\"hidden\" class=\"form-control\" name=\"result[k0_text]\" value=\"".$insert_data['k0_text']."\" required>";
						for($x=1 ;$x <= $_GET['key']; $x++){
							$string .="
					<div class=\"form-group\">
						<div class=\"row\">
							<div class=\"col-md-3\">
                                <label><?php echo \$controller->name_key('k".$x."') ?></label>
                            </div>
                            <div class=\"col-md-9\">
                                <input type=\"text\" class=\"form-control\" name=\"result[k".$x."]\" placeholder=\"Masukan <?php echo \$controller->name_key('k".$x."') ?>\" required>
							</div>
						</div>
					</div>
							";
						}
						$string .="
                    <div class=\"form-group\">
                        <input class=\"btn btn-primary\" type=\"submit\" value=\"Tambah Data\">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>";
	
										$my_file = APPPATH."views/frontend/".$insert_data['k0']."/create.php";
										$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
										fwrite($handle, $string);
										$file_create_frontend = fclose($handle);
										chmod($my_file, 01777);

										if($file_create_frontend){
										$return = 'Create View Create Done';
	
									// Created Base Creatte
										$string = "<div class=\"col-xl-12 col-lg-12\">
	<?php 
		\$data = current_url();
		\$pecah = explode(\"/\", \$data);
		\$json = file_get_contents(base_url('backend/".$insert_data['k0']."/get_id/'.\$pecah[6]));
		\$obj = json_decode(\$json, true);
		\$obj = \$obj['results'];
	?>									
    <div class=\"card shadow mb-4\">
        <!-- Card Header -->
        <div class=\"card-header py-3 d-flex flex-row align-items-center justify-content-between\">
            <h6 class=\"m-0 font-weight-bold text-primary\">Perbarui Data ".$insert_data['k0_text']." <?php echo \$obj['k1'] ?> </h6>
        </div>
        <!-- Card Body -->
        <div class=\"card-body\">
            <div class=\"col-md-12\">
                <form method=\"POST\" action=\"<?php echo base_url('/backend/".$insert_data['k0']."/update/'.\$pecah[6]) ?>\">   
                    <input type=\"hidden\" name=\"<?php echo \$this->security->get_csrf_token_name();?>\" value=\"<?php echo \$this->security->get_csrf_hash();?>\">
                    <input type=\"hidden\" class=\"form-control\" name=\"result[k0]\" value=\"".$insert_data['k0']."\" required>
                    <input type=\"hidden\" class=\"form-control\" name=\"result[k0_text]\" value=\"".$insert_data['k0_text']."\" required>";
						for($x=1 ;$x <= $_GET['key']; $x++){
							$string .="
					<div class=\"form-group\">
						<div class=\"row\">
							<div class=\"col-md-3\">
                                <label><?php echo \$controller->name_key('k".$x."') ?></label>
                            </div>
                            <div class=\"col-md-9\">
                                <input type=\"text\" class=\"form-control\" name=\"result[k".$x."]\" placeholder=\"Masukan <?php echo \$controller->name_key('k".$x."') ?>\" value=\"<?php echo \$obj['k".$x."'] ?>\" required>
							</div>
						</div>
					</div>
							";
						}
						$string .="
                    <div class=\"form-group\">
                        <input class=\"btn btn-primary\" type=\"submit\" value=\"Perbarui Data\">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>";
	
											$my_file = APPPATH."views/frontend/".$insert_data['k0']."/update.php";
											$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
											fwrite($handle, $string);
											$file_edit_frontend = fclose($handle);
											chmod($my_file, 01777);

											$return = 'Success Generate Basic CRUD , Happy Code :)';
												
										}else{
											$return = 'Create View Edit Failed';
										}
											
									}else{
										$return = 'Create View Create Failed';
									}
									
								}else{
									$return = 'Create View Main Failed';
								}
								
							}else{
								$return = 'Create View Index Failed';
							}

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
