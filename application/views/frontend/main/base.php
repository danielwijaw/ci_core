<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?php echo $this->config->item('title_aps'); ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url() ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>public/css/fontapis.css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <style>
      .ajaxloadingdata {
        color: white;
        font-weight: bold;
      }
  </style>
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() ?>public/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="<?php echo base_url() ?>public/vendor/jquery/jquery.min.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <ul id="accordionSidebar" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"></ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <div id="topbar"></div>
        <div id="root_data"></div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>&copy; <?php echo $this->config->item('title_aps'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
  <script>
    ajax("<?php echo base_url("/".$root_data) ?>","#root_data");
    ajax("<?php echo base_url('/frontend/main/sidebar') ?>","#accordionSidebar");
    ajax("<?php echo base_url('/frontend/main/topbar') ?>","#topbar");
    function ajax(url, div){
        $(div).html("<p class='ajaxloadingdata'>LOADING DATA PLEASE WAIT</p>");
        $.ajax({
            url: url,
            contentType: false,
            cache: true,
            processData: false,
            success: function(data) {
                $(div).html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $(div).html("<p class='ajaxloadingdata'>Error Catching Data</p>");
                $("#catching_error").html(XMLHttpRequest.responseText); 
                if (XMLHttpRequest.status == 0) {
                alert(' Check Your Network.');
                } else if (XMLHttpRequest.status == 404) {
                alert('Requested URL not found.');
                } else if (XMLHttpRequest.status == 500) {
                alert('Internel Server Error.');
                }  else {
                alert('Unknow Error.\n' + XMLHttpRequest.responseText);
                } 
            }
        });
    }
  </script>
</body>

</html>
