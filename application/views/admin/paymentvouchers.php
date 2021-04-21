        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('paymentvouchers'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<!--<button type="button" class="btn btn-primary" onclick="location.href = 'paymentvouchers/add'"><?php echo lang('add_paymentvoucher'); ?></button>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row" dir="rtl">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>Button Example <small>Users</small></h2>-->
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!--<p class="text-muted font-13 m-b-30">
                      The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                    </p>-->
                    <?php if(!empty($paymentvouchers)) { $staarr = array(array('class'=>'danger','output'=>lang('reject')),array('class'=>'success','output'=>lang('accept')),array('class'=>'warning','output'=>lang('warning')),array('class'=>'info','output'=>lang('new')),array(),array('class'=>'danger','output'=>lang('finishtime'))); ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('number'); ?></th>
						  <th width="10%"><?php echo lang('time'); ?></th>
						  <th width="10%"><?php echo lang('endtime'); ?></th>
						  <th><?php echo lang('quantity'); ?></th>
						  <th><?php echo lang('info'); ?></th>
						  <th><?php echo lang('model'); ?></th>
						  <th><?php echo lang('type'); ?></th>
						  <th><?php echo lang('status'); ?></th>
						  <!--<th><?php //echo lang('active'); ?></th>-->
						  <!--<th><?php echo lang('edit'); ?></th>
						  <th><?php echo lang('delete'); ?></th>-->
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($paymentvouchers as $paymentvoucher) { ?>
                        <tr class="<?php if($paymentvoucher->endtime < time() && $paymentvoucher->accept != '1') echo 'danger'; ?>">
                          <td><?php echo $paymentvoucher->pvid; ?></td>
						  <td width="10%"><?php echo date('Y-m-d , h:i:s', $paymentvoucher->pvtime); if(date('H', $paymentvoucher->pvtime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td width="10%"><?php echo date('Y-m-d , h:i:s', $paymentvoucher->endtime); if(date('H', $paymentvoucher->endtime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td><?php echo $paymentvoucher->pvquantity; ?></td>
						  <td><?php echo $paymentvoucher->item; ?></td>
						  <td><?php echo $paymentvoucher->model; ?></td>
						  <td><?php echo $paymentvoucher->type; ?></td>
						  <td>
							<div class="alert-<?php echo $staarr[$paymentvoucher->accept]['class']; ?> fade in" role="alert" style="text-align:center;">
								<strong><?php echo $staarr[$paymentvoucher->accept]['output']; ?></strong>
							</div>
						  </td>
						  <!--<td><input type="checkbox" <?php //if($paymentvoucher->active == 1) echo 'checked'; ?> disabled></td>-->
						  <!--<td><?php if($paymentvoucher->accept == '3') { ?><a href="<?php echo base_url(); ?>paymentvouchers/edit/<?php echo $paymentvoucher->pvid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a><?php } ?></td>
						  <td>
						    <?php if($paymentvoucher->accept == '3') { ?>
							<i id="<?php echo $paymentvoucher->pvid; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php echo $paymentvoucher->pvid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" onclick="location.href = 'paymentvouchers/del/<?php echo $paymentvoucher->pvid; ?>/<?php echo $paymentvoucher->pviid; ?>/<?php echo ($paymentvoucher->pvquantity)+($paymentvoucher->iquantity); ?>'" data-dismiss="modal"><?php echo lang('yes'); ?></button>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
										</center>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						</td>-->
                        </tr>
					  <?php } ?>
                      </tbody>
                    </table>
					<?php } else echo lang('no_data');?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->