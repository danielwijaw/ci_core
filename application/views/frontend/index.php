<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Antrian</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url() ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url() ?>public/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
      .ajaxloadingdata {
        color: white;
        font-weight: bold;
      }
  </style>
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url() ?>public/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-gradient-primary">

  <div class="container" id="root_data"></div>
  <div style="display:none">
    <div id="catching_error"></div>
</div>

  <script>
    ajax("<?php echo base_url($root_data) ?>","#root_data");
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
    };
  </script>

</body>

</html>
