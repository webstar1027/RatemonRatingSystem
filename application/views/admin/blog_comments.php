        
        <div class="modal fade" id="edit-comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="update-comment-blog-data">
                      <input type="hidden" name="comment_id" id="comment_id" value="">
                      <div class="modal-header"><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Edit Comment</h4></div>
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
										<label>Comment</label>
										<textarea class="form-control" rows="1" id="comment" name="comment"></textarea>
										<span id="comment_error" style="color:red;font-style:italic;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary update-comment">Save Comment</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
          </div>
        </div>
		
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
                    <h3 class="page-header">Blog Comments List</h3>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> <strong>Blog Comments List</strong>
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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-comment-list">
                                    <thead>
                                        <tr>
                                            <th>#No.</th>
											<th>Article Topic</th>
											<th>Comment</th>
											<th>IP Address</th>
                                            <th>Date</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                        <?php foreach ($comments_data as $row) { ?>
                                            <tr id="row_<?php echo $row['id']; ?>">
                                              <td><?php echo $row['id']; ?> </td>
                                              <td><?php echo $row["topic"]; ?></td>
                                              <td><?php if(strlen($row["comment"]) > 100){ echo substr($row["comment"],0 , 100).'...'; ?> <a href='javascript:void(0)' onclick="view_blog_comment('<?php echo base64_encode($row['comment']) ?>');" >Read all</a></span> <?php }else{ echo $row["comment"]; }  ?></td>
                                              <td><?php echo $row['ip_address']; ?> </td>
                                              <td><?php echo $row['date']; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                    <a onclick="remove_blog_comment('<?php echo $row['id']; ?>');" href="javascript:void(0)" class="btn btn-default btn-xs" title="Remove Comment"><i class="fa fa-trash-o fa-fw"></i></a>
                                                    <a onclick="edit_blog_comment('<?php echo $row['id']; ?>');" href="javascript:void(0)" data-toggle="modal" data-target="#edit-comment-modal" class="btn btn-default btn-xs" title="Edit Comment"><i class="fa fa-pencil-square-o fa-fw"></i></a>
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
