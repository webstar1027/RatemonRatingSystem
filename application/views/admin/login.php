<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ratemeon - Admin Login Page</title>
    <link href="<?php echo asset_dir(); ?>admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-lock fa-fw"></i>  Account Login</h3>
                    </div>
                    <div class="panel-body">
                        <?php if($this->session->flashdata('login_error')){ ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-warning fa-fw"></i> <?php echo $this->session->flashdata('login_error'); ?>.
                        </div>
                        <?php } ?>
                        <form id="login-validate" action="<?php echo base_url();?>admin/login/check_login" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password">
                                </div>
                                <button type="submit" class="btn btn-lg btn-success btn-block"><i class="fa fa-sign-in fa-fw"></i> Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo asset_dir(); ?>admin/js/jquery.js"></script>
    <script src="<?php echo asset_dir(); ?>admin/js/bootstrap.min.js"></script>
</body>

</html>
