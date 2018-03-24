<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ratemeon - Submit your First Review Today,On Rate me on you can Submit Your Reviews or add a name to get reviews from others.">
    <meta name="author" content="Naeem Farokhnia">
	<?php if($this->uri->segment(2) == 'article'){  ?>
	<title>Ratemeon - <?php echo $articles_data[0]['topic']; ?></title>
	<?php }else{ ?>
	<title>Ratemeon - Submit your Reviews on Rate me on</title>
	<?php } ?>
    <link href="<?php echo asset_dir(); ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo asset_dir(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset_dir(); ?>css/stylesheet.css" rel="stylesheet">
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113029062-1"></script>
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

	<div class="modal fade" id="view_blog_comments" tabindex="-1" role="dialog">
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
					<form class="send-blog-comment" method="post">
						<input id="article_id" type="hidden" name="article_id" value="">
						<div id="comment-blog-form" class="form-group">
						  <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Your Comment"></textarea>
						</div> 
						<button type="submit" class="pull-right btn btn-primary btn-comment-blog">Send</button>
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

	<div class="modal fade" id="insert_person">
	  <div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i style="color:#C02C30;" class="fa fa-window-close" aria-hidden="true"></i></button>
					<h4 class="modal-title" id="myModalLabel">Add Name</h4>
				</div>
				<form action="<?php echo site_url('home/insert_person')?>" method="post" id="add-people" enctype="multipart/form-data">
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
	
    <div class="container" style="margin-top:20px;">
		<a style="padding-top:10px;" href="<?php echo base_url();?>" ><button class="btn btn-primary btn-md">Ratemeon.com</button></a>
		<div class="pull-right navbar-collapse" >
			<ul class="nav navbar-nav">
				<li class="dropdown">
				  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa fa-list fa-fw fa-2x"></i></a>
				  <ul class="dropdown-menu dropdown-toggle" role="menu">
					<li><a href="javascript:void(0)" data-toggle="modal" data-target="#contact">Contact Us</a></li>
					<li><a href="javascript:void(0)" data-toggle="modal" data-target="#terms">Team</a></li>
					<li><a href="<?php echo base_url();?>blog" >Blog</a></li>
				  </ul>
				</li>
			</ul>
		</div>
		<div class="text-center">
			<br><br>
			<a href='<?php echo base_url();?>'><img src="<?php echo asset_dir();?>images/logo.jpg" alt="Lights" /></a>
			<br><br>
		</div>

		<?php if($articles_data) { ?>
        <div class="col-lg-12">
			<?php foreach ($articles_data as $row) { ?>
				<div class="panel panel-default">
				  <div class="panel-body">
					<h4 style="color:#134EA2;"><a href="<?php echo base_url();?>blog/article/<?php echo $row['slg']; ?>"><?php echo $row['topic']; ?></a></h4>
					<h5><?php echo date('F j, Y, g:i A', strtotime( $row['date'] )); ?></h5>
					<hr>
					<?php echo htmlspecialchars_decode($row['content']); ?>
					<br>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="col-md-12">
							<?php if(strlen($row["last_comment"]) > 0){ ?>
								<div class="col-md-12">
									<span><?php if(strlen($row["last_comment"]) > 200){ echo substr($row["last_comment"],0 , 200).'...'; }else{ echo $row["last_comment"]; }  ?>
								</div>
								<br>
								<div class="col-md-12">
									<a href='javascript:void(0)' onclick='view_blog_comments(<?php echo $row['id']; ?>);'>Read all comments</a></span>
								</div>
									
									
							<?php }else{ ?>
								<div class="col-md-12">	
									<a href='javascript:void(0)' onclick='view_blog_comments(<?php echo $row['id']; ?>);'><h5>Be first to comment.</h5></a>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>


				  </div>
				</div>
			<?php } ?>
		</div>

		<?php } ?>
		<div class="col-lg-12 text-center" style="margin-bottom:20px ;">
			<a href="<?php echo base_url();?>" ><button class="btn btn-primary btn-md">Ratemeon.com</button></a>
			<span class="pull-right" style=""><a href='javascript:void(0)' data-toggle="modal" data-target="#feedback"><i class="fa fa-bars fa-2x"></i></a></span>
		</div>
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
	<?php if($this->uri->segment(2) == 'article'){  ?>
	<script src="<?php echo asset_dir(); ?>js/jquery.blog.js"></script>
	<?php }else{ ?>
	<script src="<?php echo asset_dir(); ?>js/jquery.home.js"></script>
	<?php } ?>
</body>
</html>
