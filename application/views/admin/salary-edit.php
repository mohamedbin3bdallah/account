		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_salary').' '.$user->uname; ?></h3>
              </div>

              <!--<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>-->
            </div>
			
            <div class="clearfix"></div>
            
			<div class="row" dir="rtl">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>Form Design <small>different form elements</small></h2>-->
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
                    <br />
					<?php
						echo $admessage;
						echo validation_errors();
						$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
						echo form_open('hr/salaryedit/'.$user->slid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

						<input type="hidden" name="sleid" value="<?php echo $user->sleid; ?>">
						<input type="hidden" name="slename" value="<?php echo $user->uname; ?>">
						<input type="hidden" name="usalary" id="usalary" value="<?php if($user->slsalary != '00.00') echo $user->slsalary; else echo $user->usalary; ?>">
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('salary').' <span class="required">*</span>','salary',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'text',
									'name' => 'salary',
									'id' => 'salary',
									'placeholder' => lang('salary'),
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									'readonly' => 'true',
									//'value' => $user->usalary
								);
								if($user->slsalary != '00.00') $data['value'] = $user->slsalary; else $data['value'] = $user->usalary;
								echo form_input($data);
								echo ' '.$system->currency;
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('salaryitems').' <span class="required">*</span>','',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<table id="mytable" class="mytable table table-striped table-bordered nowrap"  dir="rtl">
									<tr>
										<th width="65%" style="text-align:center;"><?php echo lang('salaryitem'); ?></th>
										<th width="25%" style="text-align:center;"><?php echo lang('value'); ?></th>
										<th width="10%" style="text-align:center;"></th>
									</tr>
									<?php
									if($user->salaryitems != '')
									{
										$count = 0;
										$salaryitems = array();
										$salaryitems = explode(',',$user->salaryitems);
										foreach($salaryitems as $salaryitem)
										{
											$salaryitm = array();
											$salaryitm = explode('-',$salaryitem);
									?>
										<tr>
											<td><input type="text" name="salaryitems[]" class="form-control" value="<?php echo $salaryitm[0]; ?>" required="required"></td>
											<td><input type="text" name="values[]" class="form-control" placeholder="00.00" maxlength="10" oninput="mytotal()" value="<?php echo $salaryitm[1]; ?>" required="required" /><?php echo ' '.$system->currency; ?></td>
											<td style="text-align:center;"><?php if($count != 0) { ?><i class="delete glyphicon glyphicon-remove"></i><?php } ?></td>
										</tr>
									<?php
											$count++;
										}
									}
									else
									{
									?>
									<tr>
										<td><input type="text" name="salaryitems[]" class="form-control" required="required"></td>
										<td><input type="text" name="values[]" class="form-control" placeholder="00.00" maxlength="10" oninput="mytotal()" required="required" /><?php echo ' '.$system->currency; ?></td>
										<td style="text-align:center;"></td>
									</tr>
									<?php } ?>
								</table>
								<table class="table" style="border-style:solid;">
									<tr>
										<td width="65%" style="text-align:center; color:red;" id="totalMessage"></td>
										<td><input type="text" name="total" id="total" class="form-control" value="<?php echo $user->slsalary; ?>" readonly><?php echo ' '.$system->currency; ?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(' ','',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<i class="add btn btn-info"><?php echo lang('add_salaryitem'); ?></i>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('bonuse'),'bonuse',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'text',
									'name' => 'bonuse',
									'id' => 'bonuse',
									'placeholder' => '00.00',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->slbonuse
								);
								echo form_input($data);
								echo ' '.$system->currency;
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('gift'),'gift',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'text',
									'name' => 'gift',
									'id' => 'gift',
									'placeholder' => '00.00',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->slgift
								);
								echo form_input($data);
								echo ' '.$system->currency;
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('delay'),'delay',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'text',
									'name' => 'delay',
									'id' => 'delay',
									'placeholder' => '00.00',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->sldelay
								);
								echo form_input($data);
								echo ' '.$system->currency;
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('vacation'),'vacation',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'number',
									'name' => 'vacation',
									'id' => 'vacation',
									'placeholder' => '0',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->slvacation
								);
								echo form_input($data);
								echo ' '.lang('day');
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('sanction'),'sanction',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'number',
									'name' => 'sanction',
									'id' => 'sanction',
									'placeholder' => '0',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->slsanction
								);
								echo form_input($data);
								echo ' '.lang('day');
							?>
							</div>
						</div>
						<div class="form-group">
							<?php
								$data = array(
									'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
								);
								echo form_label(lang('absence'),'absence',$data);
							?>
							<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<?php
								$data = array(
									'type' => 'number',
									'name' => 'absence',
									'id' => 'absence',
									'placeholder' => '0',
									'class' => 'form-control col-md-7 col-xs-12',
									//'max' => 255,
									//'required' => 'required',
									//'readonly' => 'true',
									'value' => $user->slabsence
								);
								echo form_input($data);
								echo ' '.lang('day');
							?>
							</div>
						</div>
						<div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
						  <?php																				
							$data = array(
								'name' => 'submit',
								'id' => 'submit',
								'class' => 'btn btn-success',
								'value' => 'true',
								'type' => 'submit',
								'content' => lang('edit')
							);
							echo form_button($data);
						?>
                        </div>
                      </div>

                    <?php								
						echo form_close();
					?>
                  </div>
                </div>
              </div>
            </div>
		  </div>
        </div>