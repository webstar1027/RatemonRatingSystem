		<div class="modal fade" id="new-article-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" style="width:1100px;">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-sign-in"></i> New Article</h4>
				  </div>
				  <form id="new-articles"  method="post">
					  <div class="modal-body">
						 <div id="alert-error-model" class="alert alert-danger hidden">
							<button type="button" class="close dismissable">&times;</button>
							<span></span>
						 </div>
						 <div class="row">
							<div class="col-md-12">
								<div class="col-md-12">
									<div class="form-group">
										<label>Topic</label>
										<input name="topic" type="text" class="form-control" placeholder="Topic">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Content</label>
										<textarea id="summer_text" name="content"></textarea>
									</div>
								</div>
							</div>
						</div>
					  </div>
					  <div class="modal-footer">
						 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						 <button type="submit" class="btn btn-primary save-articles"><i class="fa fa-sign-in"></i> Save Article</button>
					  </div>
				  </form>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="edit-articles-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" style="width:1100px;">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title"><i class="fa fa-sign-in"></i> Edit Article</h5>
				  </div>
				  <form id="edit-articles-form"  method="post">
					  <input id="article_id" name="article_id" type="hidden" value="">
					  <div class="modal-body">
						 <div id="alert-error-model-edit" class="alert alert-danger hidden">
							<button type="button" class="close dismissable">&times;</button>
							<span></span>
						 </div>
						 <div class="row">
							<div class="col-md-12">
								<div class="col-md-12">
									<div class="form-group">
										<label>Topic</label>
										<input name="topic" type="text" class="form-control" placeholder="Topic" id="topic">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Content</label>
										<textarea id="edit_content" name="content"></textarea>
									</div>
								</div>
							</div>
						</div>
					  </div>
					  <div class="modal-footer">
						 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						 <button type="submit" class="btn btn-primary save-article-edit"><i class="fa fa-sign-in"></i> Edit Article</button>
					  </div>
				  </form>
				</div>
			</div>
		</div>
		
		<div id="view_content" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" style="width:1100px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title"><span id="article_topic"></span></h5>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<span id="article_body"></span>
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
                    <h3 class="page-header">Blog Articles</h3>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> <strong>Articles</strong>
                            <div class="pull-right">
                                <div class="btn-group">
                                        <button data-toggle="modal" data-target="#new-article-modal" type="button" class="btn btn-success btn-xs"><strong><i class="fa fa-user"></i> New Article</strong></button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
							<?php if($this->session->flashdata('message')){ ?>
                            <div id="alert-success" class="alert alert-success">
                                <button type="button" class="close dismissable">&times;</button>
                                <span><?php echo $this->session->flashdata('message'); ?></span>
                            </div>
							<?php } ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-articles-list">
                                    <thead>
                                        <tr>
                                            <th>#No.</th>
                                            <th>Topic</th>
                                            <th>Add Date</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($articles_data as $row) { ?>
                                            <tr id="row_<?php echo $row['id']; ?>">
                                              <td><?php echo $row['id']; ?> </td>
											  <td><a href="javascript:void(0)" onclick="view_content(<?php echo $row["id"]; ?>);" data-toggle="modal" data-target="#view_content"><?php echo $row["topic"]; ?></a></td>
                                              <td><?php echo $row['date']; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                    <a onclick="remove_articles('<?php echo $row['id']; ?>');" href="javascript:void(0)" class="btn btn-default btn-xs" title="Remove Articles"><i class="fa fa-trash-o fa-fw"></i></a>
                                                    <a onclick="edit_articles('<?php echo $row['id']; ?>');" href="javascript:void(0)" data-toggle="modal" data-target="#edit-articles-modal" class="btn btn-default btn-xs" title="Edit Articles"><i class="fa fa-pencil-square-o fa-fw"></i></a>
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