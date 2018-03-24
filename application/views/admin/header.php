<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="<?php echo asset_dir(); ?>images/favicon.ico"/>
    <meta name="description" content="">
    <title>Ratemeon</title>
    <link href="<?php echo asset_dir(); ?>admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/plugins/timeline.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/summernote.css" rel="stylesheet" type="text/css">
    <link href="<?php echo asset_dir(); ?>admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo asset_dir(); ?>admin/css/daterangepicker-bs3.css" />
</head>
<body>
    <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info-circle fa-fw"></i> About</h4>
          </div>
          <div class="modal-body">
           <span style="font-size:20px; color:#337AB7;"><i class="fa fa fa-users fa-lg"></i> Ratemeon v1.0</span><br><br>
           <p>Developed by <a href="mailto:nader@servesgroup.com">Nader Mohamed</a>.</p>
		   <p>for Naeem Farokhnia CEO of Ratemeon Inc.</p>
          </div>
        </div>
      </div>
    </div>
    
    <div id="wrapper">
		<nav class="navbar-default" role="navigation">
		  <div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="fa fa-bars fa-2x"></span>
				</button>
				<a class="navbar-brand" style="font-size:20px; color:#337AB7;" href="<?php echo dashboard_dir('admin/main'); ?>"><i class="fa fa fa-users fa-lg"></i> Ratemeon</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			    <ul class="nav navbar-nav">
				<li><a href="<?php echo dashboard_dir('admin/main'); ?>"><i class="fa fa-tachometer fa-fw"></i> Dashboard</a></li>
				<li><a href="<?php echo dashboard_dir('admin/people'); ?>"><i class="fa fa-users fa-fw"></i> People</a></li>
				<li><a href="<?php echo dashboard_dir('admin/comments'); ?>"><i class="fa fa-comment fa-fw"></i> Comments</a></li>
				<li><a href="<?php echo dashboard_dir('admin/blog'); ?>"><i class="fa fa-file-text-o fa-fw"></i> Blog</a></li>
				<li><a href="<?php echo dashboard_dir('admin/blog_comments'); ?>"><i class="fa fa-comment fa-fw"></i> Blog Comments</a></li>
				<li><a href="<?php echo dashboard_dir('admin/feedback'); ?>"><i class="fa fa-bars fa-fw"></i> Feedback</a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-support fa-fw"></i> Help <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><a data-toggle="modal" data-target="#about" href="#"><i class="fa fa-info-circle fa-fw"></i> About</a></li>
				  </ul>
				</li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-user fa-fw"></i> Welcome, <?php echo $this->session->userdata('full_name')?> <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <li><a href="<?php echo dashboard_dir('admin/profile'); ?>"><i class="fa fa-user fa-fw"></i> Account</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo dashboard_dir('admin/login/terminate'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                                    </ul>
                                </li>
			    </ul>
			</div>
		  </div>
		</nav>