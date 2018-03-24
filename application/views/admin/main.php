	<div class="modal fade" id="view-comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header"><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Comment</h4></div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div id="view_comments_div" ></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
	  </div>
	</div>
	
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">	   
                       <h3><i class="fa fa-dashboard"></i> Dashboard</h3>
                    </div>		
                </div>		
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Data States
                        </div>
                        <div class="panel-body">
                            <div class="list-group">
                                <a class="list-group-item">
                                    <i class="fa fa-users"></i> Total People
                                    <span class="pull-right text-muted"><strong><?php echo $total_people; ?></strong></span>
                                </a>
                                <a class="list-group-item">
                                    <i class="fa fa-comment"></i> Total Comments
                                    <span class="pull-right text-muted"><strong><?php echo $total_comments; ?></strong></span>
                                </a>
                                <a class="list-group-item">
                                    <i class="fa fa-star"></i> Total Rating
                                    <span class="pull-right text-muted"><strong><?php echo $total_rating; ?></strong></span>
                                </a>
                                <a class="list-group-item">
                                    <i class="fa fa-server"></i> Server Time
                                    <span class="pull-right text-muted"><strong><?php 
									
										$TimeZone = new DateTimeZone('America/Los_Angeles');
										$Date = new DateTime('0 hours', $TimeZone);
										echo $Date->format('Y-m-d H:i:s');

									?></strong></span>
                                </a>
                            </div>
                        </div>
                    </div>		
                </div>

                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Last 10 Comments
						</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#No.</th>
											<th>Name</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ($last_comments as $row) { ?>
										<tr id="row_<?php echo $row['id']; ?>">
										  <td><?php echo $row['id']; ?> </td>
										  <td><?php echo $row['name']; ?> </td>
										  <td><?php if(strlen($row["comment"]) > 200){ echo substr($row["comment"],0 , 200).'...'; ?> <a href='javascript:void(0)' onclick="view_comment('<?php echo base64_encode($row['comment']) ?>');" >Read all</a></span> <?php }else{ echo $row["comment"]; }  ?></td>
										  <td><?php echo $row['date']; ?></td>
										</tr>
									<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
				
            </div>
        </div>