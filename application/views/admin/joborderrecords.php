        <!-- page content -->
        <div class="right_col" role="main" <?php if($joborder[0]->endtime < time() && $joborder[0]->accept != '1') echo 'style="background-color:#f9e6e5;"'; ?>>
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('joborderrecords').' '.$id; ?></h3>
				<br>
				<h3 style="text-align:center;"><?php echo lang('endtime').' '.ArabicTools::arabicDate($system->calendar.' d-m-Y', $joborder[0]->endtime).' , '.date('h:i:s', $joborder[0]->endtime); if(date('H', $joborder[0]->endtime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<!--<button type="button" class="btn btn-primary" onclick="location.href = 'orders/add'"><?php //echo lang('add_order'); ?></button>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

			<div class="row" dir="rtl">
				<?php
				if($joborder[0]->accept == '2' && strpos($this->loginuser->privileges, ',joedit,') !== false) {
					echo $admessage;
					echo validation_errors();
					$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
					echo form_open_multipart('joborders/records/'.$id, $attributes);
				?>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('notes').' <span class="required">*</span>','notes',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'name' => 'notes',
								'id' => 'notes',
								'placeholder' => lang('notes'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'required' => 'required',
								'value' => ''//set_value('notes')
							);
							echo form_textarea($data);
						  ?>
                        </div>
                      </div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
						  <?php																				
							$data = array(
								'name' => 'submit',
								'id' => 'submit',
								'class' => 'btn btn-success',
								'value' => 'true',
								'type' => 'submit',
								'content' => lang('save')
							);
							echo form_button($data);
						?>
                        </div>
                      </div>
					</div>
				<?php
					echo form_close();
				}
				?>
			</div>
			
			<?php
			if($joborder[0]->jouid == $this->session->userdata('uid') && $joborder[0]->accept == '2' && strpos($this->loginuser->privileges, ',joedit,') !== false) {
				//echo $admessage;
				//echo validation_errors();
				$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
				echo form_open_multipart('joborders/done/'.$id.'/'.$joborder[0]->jooid, $attributes);
			?>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
					<div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
						<button type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#danger"><?php echo lang('closefail'); ?></button>
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
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
						<button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target="#success"><?php echo lang('closesuccess'); ?></button>
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
			<?php 
			}
			elseif($joborder[0]->jouid == $this->session->userdata('uid') && $joborder[0]->accept != '2' && strpos($this->loginuser->privileges, ',joedit,') !== false) {
				//echo $admessage;
				//echo validation_errors();
				$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
				echo form_open_multipart('joborders/done/'.$id.'/'.$joborder[0]->jooid, $attributes);
			?>
			<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
						<button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target="#success"><?php echo lang('open'); ?></button>
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
				</div>
			</div>
			<?php } ?>
			
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
                    <?php if(!empty($records)) { ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('user'); ?></th>
						  <th width="20%"><?php echo lang('time'); ?></th>
						  <th><?php echo lang('notes'); ?></th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($records as $record) { ?>
                        <tr>
                          <td><?php echo $record->user; ?></td>
						  <td width="10%"><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $record->time).' , '.date('h:i:s', $record->time); if(date('H', $record->time) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td><?php echo $record->notes; ?></td>
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