<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ratemeon rate people you maybe know">
    <meta name="author" content="Naeem Farokhnia">
    <title>Ratemeon - Error 404.</title>
    <link href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/css/bootstrap.css" rel="stylesheet">
	<link href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/css/stylesheet.css" rel="stylesheet">
</head>
<body>
    <div class="container">
		<div class="text-center" style="padding-top:50px;">
			<a href='https://<?php echo $_SERVER['SERVER_NAME']; ?>/'><img src="https://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/images/logo.jpg" alt="Lights" /></a>
			<h1 style="color:#3F6290; padding-top:80px;"><?php echo $heading; ?></h1>
			<?php echo $message; ?>
		</div>
    </div>
</body>
</html>