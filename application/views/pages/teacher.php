<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ratemeon - Submit your First Review Today,On Rate me on you can Submit Your Reviews or add a name to get reviews from others.">
    <meta name="author" content="Naeem Farokhnia">
    <title>Ratemeon - Submit your Reviews on Rate me on</title>
    <link href="<?php echo asset_dir(); ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo asset_dir(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>css/stylesheet.css" rel="stylesheet">

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113029062-1"></script>;
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-113029062-1');
	</script>
</head>
<body>

	<div class="modal fade" id="terms" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-pin"></i> Team</h4>
			  </div>
			  <div class="modal-body">
				<p>Naeem Farokhnia, PhD is the founder and CEO of RateMeOn Inc.</p>
			  </div>
			  <div class="modal-footer">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
	    </div>
	</div>

	<div class="modal fade" id="contact" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i style="color:#C02C30;" class="fa fa-window-close" aria-hidden="true"></i></button>
				<h4 class="modal-title"><i class="fa fa-contact"></i> Contact Us</h4>
			  </div>
			  <div class="modal-body">
				<div id="alert-success-model-contact" class="alert alert-success hidden">
					<button type="button" class="close dismissable">&times;</button>
					<span></span>
				</div>
				<div class="col-md-12">
					<form id="send-contact" method="post">

						<div id="contact_name_error" class="form-group">
							<input class="form-control" name="contact_name" placeholder="Your Name">
							<span style="color:red;font-style:italic;"></span>
						</div> 
						<div id="contact_email_error" class="form-group">
							<input class="form-control" name="contact_email" placeholder="Your Email">
							<span style="color:red;font-style:italic;"></span>
						</div>
						<div id="contact_text_error" class="form-group">
							<textarea class="form-control" rows="3" id="contact_text" name="contact_text" placeholder="Your message"></textarea>
							<span style="color:red;font-style:italic;"></span>
						</div> 
						<button type="submit" class="pull-right btn btn-primary btn-contact">Send</button>
					</form>
					<br>
				</div>
			  </div>
			</div>
	    </div>
	</div>

	<div class="modal fade" id="view_comments" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i style="color:#C02C30;" class="fa fa-window-close" aria-hidden="true"></i></button>
				<h4 class="modal-title"><i class="fa fa-comment"></i> Comments</h4>
			  </div>
			  <div class="modal-body">
				<div id="alert-error-model" class="alert alert-danger hidden">
					<button type="button" class="close dismissable">&times;</button>
					<span></span>
				</div>

				<div id="view_comments_loading" class="col-md-12 text-center">
					<br><br>
					<p><img src="<?php echo asset_dir(); ?>images/loader.gif" alt="Loading..."></p>
					<br><br>
				</div>
				<div id="no-comments" class="col-md-12 text-center">
					<br><br>
					<p>Be first to comment.</p>
					<br><br>
				</div>
				<div id="view_comments-list" class="col-md-12">
					<div id="view_comments_div" ></div>
				</div>
				
				<div class="col-md-12">
					<hr>
					<div id="alert-success-model-comment" class="alert alert-success hidden">
						<button type="button" class="close dismissable">&times;</button>
						<span></span>
					</div>
					<div id="alert-error-model-comment" class="alert alert-danger hidden">
						<button type="button" class="close dismissable">&times;</button>
						<span></span>
					</div>
					<form class="send-comment" method="post">
						<input id="people_id" type="hidden" name="people_id" value="">
						<div id="comment-form" class="form-group">
						  <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Your Comment"></textarea>
						</div> 
						<button type="submit" class="pull-right btn btn-primary btn-comment">Send</button>
					</form>
					<br><br><br>
				</div>
			  </div>
			</div>
	    </div>
	</div>
	
	<div class="modal fade" id="feedback" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-body">
				<div id="alert-success-model-feedback" class="alert alert-success hidden">
					<button type="button" class="close dismissable">&times;</button>
					<span></span>
				</div>
				<form id="feedback-form" method="post">
					<div id="feedback-text" class="form-group">
					  <textarea class="form-control" rows="3" id="feedback-text" name="feedback" placeholder="Your Feedback"></textarea>
					</div>
					<button type="submit" class="pull-right btn btn-primary btn-feedback">Send</button>
				</form>
			  </div>
			</div>
	    </div>
	</div>

	<div class="modal fade" id="insert_teacher">
	  <div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i style="color:#C02C30;" class="fa fa-window-close" aria-hidden="true"></i></button>
					<h4 class="modal-title" id="myModalLabel">Add Name</h4>
				</div>
				<form action="<?php echo site_url('movepage/insert_teacher')?>" method="post" id="add-people" enctype="multipart/form-data">
				<div class="modal-body">
					<div id="alert-error-model-insert" class="alert alert-danger hidden">
						<button type="button" class="close dismissable">&times;</button>
						<span></span>
					</div>
					<div id="alert-success-model-insert" class="alert alert-success hidden">
						<button type="button" class="close dismissable">&times;</button>
						<span></span>
					</div> 
					<div id="number-limits-error" class="alert alert-danger hidden">
							<button id="dismissable" type="button" class="close">&times;</button>
							<span></span>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Name">
							</div>
							<div class="form-group">
								<label class="control-label">School</label>
								<input type="text" name="school_name" class="form-control" placeholder="School Name">
							</div>
							<div class="form-group">
								<label class="control-label">City</label>
								<input type="text" name="city" class="form-control" placeholder="City">
							</div>
							<div class="form-group">
								<label class="control-label">State</label>
								<input type="text" name="state" class="form-control" placeholder="State">
							</div>
							<div class="form-group">
								<label class="control-label">Picture File</label>
								<input name="sound_file" id="sound_file" type="file"/>
							</div>
							<div class="form-group">
								<label style="color:#D33D41"></label>
								<span style="color:#D33D41;font-style:italic;">“File types jpg, jpeg, and png are allowed”</span>
							</div>
							<div class="progress progress-sm mbn" style="margin-top:40px; display:none;">
								<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
									style="" class="progress-bar progress-bar-info">
									<span class="sr-only">0% Complete</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
					<button type="submit" class="btn btn-primary">Add Name</button>
				</div>
				</form>
			</div>
	  </div>
	</div>
	
	<div class="modal fade" id="give_rating" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">

			  <div class="modal-body">
				<div id="alert-error-model" class="alert alert-danger hidden">
					<button type="button" class="close dismissable">&times;</button>
					<span></span>
				</div>
				<div class="row">
					 <div class="col-md-12">
							
						  <div class='rating-stars star-box'  style="text-align:center">
							
							<ul class='stars'>
								<input type="hidden" id="rating_people_id" name="rating_people_id" value="">
							  <li class='star' title='Poor' data-value='1'>
								<i class='fa fa-star fa-fw'></i>
							  </li>
							  <li class='star' title='Fair' data-value='2'>
								<i class='fa fa-star fa-fw'></i>
							  </li>
							  <li class='star' title='Good' data-value='3'>
								<i class='fa fa-star fa-fw'></i>
							  </li>
							  <li class='star' title='Excellent' data-value='4'>
								<i class='fa fa-star fa-fw'></i>
							  </li>
							  <li class='star' title='WOW!!!' data-value='5'>
								<i class='fa fa-star fa-fw'></i>
							  </li>
							</ul>
						  </div>
						  <div class='success-box'>
								<div class='clearfix'></div>
								<div class='text-message'></div>
								<div class='clearfix'></div>
						  </div>
					</div>
				</div>
			  </div>

			</div>
	    </div>
	</div>
	
    <div class="container">
		<div>
			<div class="col-lg-6" style="padding-top:15px;">
				<button  data-toggle="modal" data-target="#insert_teacher" type="submit" class="btn btn-primary btn-md">Add Name</button>
			</div>
			<div class="col-lg-6">
			
				<div class="pull-right collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav" style="">
						<li class="dropdown">
						  <a href="javascript:void(0)"  data-toggle="dropdown" role="button"><i class="fa fa fa-list fa-fw fa-2x"></i></a>
						  <ul class="dropdown-menu" role="menu">
							<li><a href="javascript:void(0)" data-toggle="modal" data-target="#contact">Contact Us</a></li>
							<li><a href="javascript:void(0)" data-toggle="modal" data-target="#terms">Team</a></li>
							<li><a href="<?php echo base_url();?>blog/" >Blog</a></li>
						  </ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="text-center">
			<a href='<?php echo base_url();?>'><img src="<?php echo asset_dir();?>images/logo.jpg" alt="Lights" /></a>
			<br><br>
		</div>
        <div>
			<form id="teacher-search-form" method="POST" action="<?php echo base_url();?>rate-my-teacher">
				<div class="col-md-12">
					<div class="form-group">
						<input type="text" name="search_name" id="teacher_auto_complete" class="form-control input-lg" placeholder="Search For Name" value="<?php if(isset($_POST['search_name'])){echo $_POST['search_name']; }?>">
					</div>
				</div>
			</form>
			<br><br><br>
        </div>
		<?php if($people_data) { ?>
        <div class="col-lg-12">
			<?php foreach ($people_data as $row) { ?>
				<div class="col-lg-12 thumbnail" style="height:170px;">
					<div class="col-lg-2" style="width:160px; height:160px; text-align: left; background-image: url('<?php echo asset_dir(); ?>images/<?php if(is_null($row['picture'])){ echo 'default.jpg'; }else{ echo $row['picture']; } ?>'); background-repeat: no-repeat;  background-position: center;  background-size: <?php if($row['picture_width'] == 0){ echo 160; }else{ echo $row['picture_width']; } ?>px <?php if($row['picture_height'] == 0){ echo 160; }else{ echo $row['picture_height']; } ?>px;"></div>
					<div class="col-md-10">
						<div class="col-md-12">
							<div class=''>
								<?php
									$id = $row['id'];
									@$ratings_stars = round(($row['star_1'] + $row['star_2'] * 2 + $row['star_3'] * 3 + $row['star_4'] * 4 + $row['star_5'] * 5) / $row['total_rating'], 1, PHP_ROUND_HALF_ODD);
									
									
									
									$pieces = explode(".", $ratings_stars);
									@$pieces = $pieces[1].'0';

									$pieces = $pieces - 13;

									
									if($row['total_rating'] > 0)
									{
										for( $i= 1 ; $i <= $ratings_stars ; $i++ )
										{
											echo "<a href='javascript:void(0)' onclick='give_rating($id);'><i class='star-in star-under fa fa-star'><i class='star-in star-over fa fa-star' style='width: 100%'></i></i></a>";
										}
										
										if($pieces > 0)
										{
											echo "<a href='javascript:void(0)' onclick='give_rating($id);'><i class='star-in star-under fa fa-star'><i class='star-in star-over fa fa-star' style='width: ".$pieces."%'></i></i></a>";
										
											$i = ($i + 1);

										}
										
										for( $x = $i ; $x <= 5 ; $x++ )
										{
											echo "<a href='javascript:void(0)' onclick='give_rating($id);'><i class='star-in star-under fa fa-star'><i class='star-in star-empty fa fa-star' ></i></i></a>";
										}
										
									}else{
										
										$x - 1;
										
										for( $x= 1 ; $x <= 5 ; $x++ )
										{
											echo "<a href='javascript:void(0)' onclick='give_rating($id);'><i class='star-in star-under fa fa-star'><i class='star-in star-empty fa fa-star' ></i></i></a>";
										}
									}
								?>
								<span class="name_class" style="padding-left:40px;"><?php echo $row['name']; ?></span>					
							</div>
						</div>
						<div class="col-md-12">
						<?php if(strlen($row["last_comment"]) > 0){ ?>
							<div class="col-md-12">
								<span><?php if(strlen($row["last_comment"]) > 200){ echo substr($row["last_comment"],0 , 200).'...'; }else{ echo $row["last_comment"]; }  ?>
							</div>
							<br>
							<div class="col-md-12">
								<a href='javascript:void(0)' onclick='view_comments(<?php echo $row['id']; ?>);'>Read all comments</a></span>
							</div>
								
								
						<?php }else{ ?>
							<div class="col-md-12">	
								<a href='javascript:void(0)' onclick='view_comments(<?php echo $row['id']; ?>);'><h5>Be first to comment.</h5></a>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-md-offset-5">
					<ul style="list-style-type: square; margin-top: -170px; margin-left:230px">
					  <li class="name_class" style="font-size: 18px !important;"> <?php echo $row['question1'];?> teacher</li>
					  <li class="name_class" style="font-size: 18px !important;"> <?php echo $row['city'];?>, <?php echo $row['state'];?></li>
					</ul>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-lg-12 text-center">
					<?php echo $links;?>
				</div>
			</div>
		</div>
		<div class="col-lg-12 text-center" style="margin-bottom:20px ;">
			<button data-toggle="modal" data-target="#insert_teacher" type="submit" class="btn btn-primary btn-sm ">Add Name</button>
			<span class="pull-right" style=""><a href='javascript:void(0)' data-toggle="modal" data-target="#feedback"><i class="fa fa-bars fa-2x"></i></a></span>
		</div>
		<?php }else{ ?>
		<div class="col-lg-12 text-center">
			<br>
			<button data-toggle="modal" data-target="#insert_teacher" type="submit" class="btn btn-primary btn-lg ">Add Name</button>
		</div>
		<div style="margin-bottom:250px ;"></div>
		<div class="col-lg-12">
			<span class="pull-right" style=""><a href='javascript:void(0)' data-toggle="modal" data-target="#feedback"><i class="fa fa-bars fa-2x"></i></a></span>
		</div>
		<br>
		<?php } ?>
        <hr>
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>© <?php echo date('Y'); ?> Ratemeon All Rights Reserved</p>
                </div>
				
            </div>
        </footer>
    </div>
    <script src="<?php echo asset_dir(); ?>js/jquery.js"></script>
    <script src="<?php echo asset_dir(); ?>js/bootstrap.min.js"></script>
	<script src="<?php echo asset_dir(); ?>js/jquery.auto-complete.js"></script>
	<script src="<?php echo asset_dir(); ?>js/jquery.home.js"></script>
</body>
</html>
