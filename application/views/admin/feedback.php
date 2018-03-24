
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Feedback List</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> <strong>Feedback List</strong>
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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-feedback-list">
                                    <thead>
                                        <tr>
                                            <th>#No.</th>
											<th>Feedback</th>
											<th>IP Address</th>
                                            <th>Date</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                        <?php foreach ($comments_data as $row) { ?>
                                            <tr id="row_<?php echo $row['id']; ?>">
                                              <td><?php echo $row['id']; ?> </td>
                                              <td><?php echo $row['feedback']; ?></td>
                                              <td><?php echo $row['ip_address']; ?> </td>
                                              <td><?php echo $row['date']; ?></td>
                                              <td>
                                                <div class="btn-group">
                                                    <a onclick="remove_feedback('<?php echo $row['id']; ?>');" href="javascript:void(0)" class="btn btn-default btn-xs" title="Remove Comment"><i class="fa fa-trash-o fa-fw"></i></a>
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
