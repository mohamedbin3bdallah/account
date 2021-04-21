        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('paymentvouchers'); ?></h3>
              </div>

              <!--<div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<button type="button" class="btn btn-primary" onclick="location.href = 'paymentvouchers/add'"><?php echo lang('add_paymentvoucher'); ?></button>
                  </div>
                </div>
              </div>-->
            </div>

            <div class="clearfix"></div>
			
			<?php if(!empty($id)) { ?>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
					<table id="" class="table table-striped table-bordered"  dir="rtl">
						<tr>
							<td><?php echo lang('date'); ?></td>
							<td><?php echo date('Y-m-d', $id); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<?php } ?>
			
			<?php if(!empty($paymentvouchers)) { $staarr = array(array('class'=>'danger','output'=>lang('reject')),array('class'=>'success','output'=>lang('accept')),array('class'=>'warning','output'=>lang('warning')),array('class'=>'info','output'=>lang('new')),array(),array('class'=>'danger','output'=>lang('finishtime'))); ?>
			<?php
				//echo $admessage;
				//echo validation_errors();
				if(strpos($this->loginuser->privileges, ',pvedit,') !== false) {
				$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
				echo form_open_multipart('paymentvouchers/status', $attributes);
			?>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
					<div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
						<button type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#danger"><?php echo lang('reject'); ?></button>
						<div id="danger" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<?php echo lang('continueproccess'); ?>
										<br>
									</div>
									<div class="modal-body">
										<center>
											<?php
												$data = array(
													'name' => 'submit',
													'id' => 'submit',
													'class' => 'btn btn-danger',
													'value' => '0',
													'type' => 'submit',
													'content' => lang('yes')
												);
												echo form_button($data);
											?>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
									</center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
						<button type="button" class="btn btn-round btn-warning" data-toggle="modal" data-target="#warning"><?php echo lang('warning'); ?></button>
						<div id="warning" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<?php echo lang('continueproccess'); ?>
										<br>
									</div>
									<div class="modal-body">
										<center>
											<?php
												$data = array(
													'name' => 'submit',
													'id' => 'submit',
													'class' => 'btn btn-danger',
													'value' => '2',
													'type' => 'submit',
													'content' => lang('yes')
												);
												echo form_button($data);
											?>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
									</center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
						<button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target="#success"><?php echo lang('accept'); ?></button>
						<div id="success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<?php echo lang('continueproccess'); ?>
										<br>
									</div>
									<div class="modal-body">
										<center>
											<?php
												$data = array(
													'name' => 'submit',
													'id' => 'submit',
													'class' => 'btn btn-danger',
													'value' => '1',
													'type' => 'submit',
													'content' => lang('yes')
												);
												echo form_button($data);
											?>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
									</center>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			
            <div class="row"  dir="rtl">
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
					<table id="datatable-buttons" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
						  <?php if(strpos($this->loginuser->privileges, ',pvedit,') !== false) { ?><th><input type="checkbox" id="check-all" class="flat"></th><?php } ?>
                          <th><?php echo lang('number'); ?></th>
						  <th><?php echo lang('time'); ?></th>
						  <th><?php echo lang('info'); ?></th>
						  <th><?php echo lang('quantity'); ?></th>
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('status'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',pvedit,') !== false) { ?><th><?php echo lang('message'); ?></th><?php } ?>
						  <!--<th><?php //echo lang('edit'); ?></th>-->
						  <!--<th><?php //echo lang('delete'); ?></th>-->
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($paymentvouchers as $paymentvoucher) { ?>
                        <tr class="<?php if($paymentvoucher->endtime < time() && $paymentvoucher->accept != '1') echo 'danger'; ?>">
						  <?php if(strpos($this->loginuser->privileges, ',pvedit,') !== false) { ?><td><?php if($paymentvoucher->endtime > time() && $paymentvoucher->accept != '1') { ?><input type="checkbox" class="flat" name="table_records[]" value="<?php echo $paymentvoucher->pvid; ?>"></td><?php } } ?>
                          <td><?php echo $paymentvoucher->pvid; ?></td>
						  <td><a href="<?php echo base_url(); ?>paymentvouchers/date/<?php echo date('Y-m-d', $paymentvoucher->pvtime); ?>"><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $paymentvoucher->pvtime).' , '.date('h:i:s', $paymentvoucher->pvtime); if(date('H', $paymentvoucher->pvtime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></a></td>
						  <td><a href="<?php echo base_url(); ?>paymentvouchers/item/<?php echo $paymentvoucher->pviid; ?>"><?php echo $paymentvoucher->item.' ( '.$paymentvoucher->model.' - '.$paymentvoucher->type.' )'; ?></a></td>
						  <td><?php echo $paymentvoucher->pvquantity; ?></td>
						  <td><a href="<?php echo base_url(); ?>paymentvouchers/user/<?php echo $paymentvoucher->pvuid; ?>"><?php echo $paymentvoucher->user; ?></a></td>
						  <td>
							<div class="alert-<?php echo $staarr[$paymentvoucher->accept]['class']; ?> fade in" role="alert" style="text-align:center;">
								<strong><?php echo $staarr[$paymentvoucher->accept]['output']; ?></strong>
							</div>
						  </td>
						  <?php if(strpos($this->loginuser->privileges, ',pvedit,') !== false) { ?><td><?php if(isset($admessagearr[$paymentvoucher->pvid])) echo $admessagearr[$paymentvoucher->pvid]; ?></td><?php } ?>
						  <!--<td><a href="<?php echo base_url(); ?>paymentvouchers/edit/<?php echo $paymentvoucher->pvid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a></td>-->
						  <!--<td>
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
						  </td>-->
                        </tr>
					  <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
			<?php
				echo form_close();
			?>
			<?php } else echo '<div dir="rtl">'.lang('no_data').'</div>'; ?>
			
          </div>
        </div>
        <!-- /page content -->