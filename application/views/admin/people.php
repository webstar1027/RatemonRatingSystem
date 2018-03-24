        <div class="modal fade" id="new-people-modal">
          <div class="modal-dialog modal-md">
                <div class="modal-content">
						<div class="modal-header"><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> New People</h4></div>
						<form action="<?php echo site_url('admin/people/insert_people')?>" method="post" id="add-people" enctype="multipart/form-data">
						<div class="modal-body">
                            <div id="alert-error-model" class="alert alert-danger hidden">
                                <button type="button" class="close dismissable">&times;</button>
                                <span></span>
                            </div>
                            <div id="alert-success-model" class="alert alert-success hidden">
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
										<span style="color:#D33D41;font-style:italic;">“File types jpg, jpeg, and png are allowed”</span>
										
									</div>
									<div class="progress progress-sm mbn" style="margin-top:40px;">
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
							<button type="submit" class="btn btn-primary">Add People</button>
						</div>
						</form>
                </div>
          </div>
        </div>
        
        <div class="modal fade" id="edit-people-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md">
                <div class="modal-content">
					<form action="<?php echo site_url('admin/people/update_people')?>" method="post" id="update-people-data" enctype="multipart/form-data">
                      <input type="hidden" name="people_id" id="people_id" value="">
                      <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Edit People</h4></div>
                        <div class="modal-body">
                            <div id="alert-error-model" class="alert alert-danger hidden">
                                <button type="button" class="close dismissable">&times;</button>
                                <span></span>
                            </div>
                            <div id="alert-success-model" class="alert alert-success hidden">
                                <button type="button" class="close dismissable">&times;</button>
                                <span></span>
                            </div> 
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Name</label>
										<input id="edit_name" type="text" name="name" class="form-control" placeholder="Name">
									</div>
									<div class="form-group">
										<label class="control-label">Picture File</label>
										<input name="sound_file" id="sound_file" type="file"/>
									</div>
									<div class="form-group">
										<span style="color:#D33D41;font-style:italic;">“File types jpg, jpeg, and png are allowed”</span>
										
									</div>
									<div class="progress progress-sm mbn" style="margin-top:40px;">
										<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
											style="" class="progress-bar progress-bar-info">
											<span class="sr-only">0% Complete</span>
										</div>
									</div>
								</div>
							</div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary update-people">Save People</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
          </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">People List</h3>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> <strong>People List</strong>
                            <div class="pull-right">
                                <div class="btn-group">
                                        <button data-toggle="modal" data-target="#new-people-modal" type="button" class="btn btn-success btn-xs"><strong><i class="fa fa-user"></i> New People</strong></button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="alert-error" class="alert alert-danger hidden">
                                <button type="button" class="close dismissable">&times;</button>
                                <span></span>
                            </div>
                            <div id="alert-success" class="alert alert-success hidden">
                                <button type="button" class="close dismissable">&times;</button>
                                <span></span>
                            </div>  
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-people-list">
                                    <thead>
                                        <tr>
                                            <th>#No.</th>
                                            <th>Picture</th>
											<th>Name</th>
											<th>Rating Value</th>
											<th>Total Ratings</th>
											<th>Total Comments</th>
                                            <th>Add Date</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($people_data as $row) { ?>
                                            <tr id="row_<?php echo $row['id']; ?>">
                                              <td><?php echo $row['id']; ?> </td>
											  <td>
											  <?php if(is_null($row["picture"])){ ?>
												<center><img src="<?php echo asset_dir(); ?>images/default.jpg" alt="" class="img-rounded" style="width:65px; height:74px;" ></center>
											  <?php }else{ ?>
												<center><img src="<?php echo asset_dir(); ?>images/<?php echo $row['picture']; ?>" alt="<?php echo $row['name']; ?>" class="img-rounded" style="width:65px; height:74px;" ></center>
											  <?php } ?>
											  </td>
                                              <td><?php echo $row['name']; ?> </td>
											  <td>
											  <?php
											  if($row['total_rating'] > 0)
											  {
												echo round(($row['star_1'] + $row['star_2'] * 2 + $row['star_3'] * 3 + $row['star_4'] * 4 + $row['star_5'] * 5) / $row['total_rating'], 1, PHP_ROUND_HALF_ODD);
											  }
											  else
											  {
												echo 'No Rating';
											  }
											  ?>
											  </td>
                                              <td><?php echo $row['total_rating']; ?> </td>
                                              <td><?php echo $row['total_comments']; ?></td>
                                              <td><?php echo $row['date']; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                    <a onclick="remove_people('<?php echo $row['id']; ?>');" href="javascript:void(0)" class="btn btn-default btn-xs" title="Remove People"><i class="fa fa-trash-o fa-fw"></i></a>
                                                    <a onclick="edit_people('<?php echo $row['id']; ?>');" href="javascript:void(0)" data-toggle="modal" data-target="#edit-people-modal" class="btn btn-default btn-xs" title="Edit People"><i class="fa fa-pencil-square-o fa-fw"></i></a>
                                                </div>
                                              </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>		
            </div>
        </div>