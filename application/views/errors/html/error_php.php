<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Error - PHP</title>

  <!-- Custom fonts for this template-->
  <link href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/public/css/fontapis.css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/public/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div style="background:white" class="o-hidden border-0 shadow-lg my-5">
            <div class="text-center">
                <div class="error mx-auto" data-text="404">PHP</div>
                <p class="lead text-gray-800 mb-5">PHP</p>
				<p class="text-gray-500 mb-0"><?php echo $message; ?></p>
				<p class="text-gray-500 mb-0">Severity: <?php echo $severity; ?></p>
				<p class="text-gray-500 mb-0">Message:  <?php echo $message; ?></p>
				<p class="text-gray-500 mb-0">Filename: <?php echo $filepath; ?></p>
				<p class="text-gray-500 mb-0">Line Number: <?php echo $line; ?></p>
				<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

				<p class="text-gray-500 mb-0">Backtrace:</p>
				<?php foreach (debug_backtrace() as $error): ?>

					<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

						<p class="text-gray-500 mb-0" style="margin-left:10px">
						File: <?php echo $error['file'] ?><br />
						Line: <?php echo $error['line'] ?><br />
						Function: <?php echo $error['function'] ?>
						</p>

					<?php endif ?>

				<?php endforeach ?>

				<?php endif ?>
                <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>">&larr; Back to Dashboard</a>
            </div>
        </div>

      </div>

    </div>

  </div>

</body>

</html>
