        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('info_user').' '.$salaries[0]->uname; ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<!--<?php //if(strpos($this->loginuser->privileges, ',uadd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'users/add'"><?php //echo lang('add_user'); ?></button><?php //} ?>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

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
                    <h2></h2>
                    <!-- Tabs -->
                    <div id="wizard_verticle" class="form_wizard wizard_verticle">
					<?php for($mcount=0;$mcount<$currentmonth;$mcount++) { ?>
                      <?php if($mcount%3 == 0) { ?><ul class="list-unstyled wizard_steps" style="float:right"><?php } ?>
                        <li>
                          <a href="#step-<?php echo $mcount; ?>">
                            <span class="step_no"><?php echo lang('month'.$system->calendar.($mcount+1)); ?></span>
                          </a>
                        </li>
					<?php if($mcount%3 == 2) { ?></ul><?php } ?>
					<?php } ?>

					<?php for($mcount=0;$mcount<($currentmonth-1);$mcount++) { ?>
                      <div id="step-<?php echo $mcount; ?>">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('salary').' ('.lang('month'.$system->calendar.($mcount+1)).')'; ?></h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active" style="float:right;"><a href="#show<?php echo $mcount; ?>" id="show<?php echo $mcount; ?>-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
							<li role="presentation" class="" style="float:right;"><a href="#add<?php echo $mcount; ?>" role="tab" id="add<?php echo $mcount; ?>-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
						</ul>
						<div id="tab<?php echo $mcount; ?>" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="show<?php echo $mcount; ?>" aria-labelledby="show<?php echo $mcount; ?>-tab">
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('salary').' <span class="required">*</span>','salary',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slsalary.' '.$system->currency;
								?>
								</div>
							</div>
							<?php if($salaries[$mcount]->salaryitems != '') { $salaryitems[$mcount] = explode(',',$salaries[$mcount]->salaryitems); ?>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('salaryitems').' <span class="required">*</span>','',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
									<table class="table table-striped table-bordered nowrap"  dir="rtl">
										<tr>
											<th width="65%" style="text-align:center;"><?php echo lang('salaryitem'); ?></th>
											<th width="25%" style="text-align:center;"><?php echo lang('value'); ?></th>
										</tr>
										<?php foreach($salaryitems[$mcount] as $salary[$mcount]) { $salaryitem[$mcount] = explode('-',$salary[$mcount]); ?>
										<tr>
											<td><?php echo $salaryitem[$mcount][0]; ?></td>
											<td><?php echo $salaryitem[$mcount][1].' '.$system->currency; ?></td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
							<?php } ?>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('bonuse'),'bonuse',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slbonuse.' '.$system->currency;
								?>
								</div>
							</div>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('gift'),'gift',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slgift.' '.$system->currency;
								?>
								</div>
							</div>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('delay'),'delay',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->sldelay.' '.$system->currency;
								?>
								</div>
							</div>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('vacation'),'vacation',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slvacation.' '.lang('day');
								?>
								</div>
							</div>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('sanction'),'sanction',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slsanction.' '.lang('day');
								?>
								</div>
							</div>
							<div class="row">
								<?php
									$data = array(
										'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
									);
									echo form_label(lang('absence'),'absence',$data);
								?>
								<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
								<?php
									echo $salaries[$mcount]->slabsence.' '.lang('day');
								?>
								</div>
							</div>
							<div class="ln_solid"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="add<?php echo $mcount; ?>" aria-labelledby="add<?php echo $mcount; ?>-tab">
							add2
						</div>
						</div>
						</div>
						</div>
                      </div>
					  <?php } ?>

					  <div id="step-<?php echo $currentmonth-1; ?>">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('salary').' ('.lang('month'.$system->calendar.($currentmonth-1+1)).')'; ?></h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active" style="float:right;"><a href="#show<?php echo $currentmonth-1; ?>" id="show<?php echo $currentmonth-1; ?>-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
							<li role="presentation" class="" style="float:right;"><a href="#add<?php echo $currentmonth-1; ?>" role="tab" id="add<?php echo $currentmonth-1; ?>-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
						</ul>
						<div id="tab<?php echo $currentmonth-1; ?>" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="show<?php echo $currentmonth-1; ?>" aria-labelledby="show<?php echo $currentmonth-1; ?>-tab">
							<?php
								//echo $admessage;
								echo validation_errors();
								$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
								echo form_open('users/salary/'.$salaries[0]->uid, $attributes);
							?>
							<input type="hidden" name="sleid" value="<?php echo $salaries[0]->uid; ?>">
							<input type="hidden" name="slename" value="<?php echo $salaries[0]->uname; ?>">
							<input type="hidden" name="usalary" id="usalary" value="<?php if($salaries[$currentmonth-1]->slsalary != '00.00') echo $salaries[$currentmonth-1]->slsalary; else echo $salaries[0]->usalary; ?>">
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
									if($salaries[$currentmonth-1]->slsalary != '00.00') $data['value'] = $salaries[$currentmonth-1]->slsalary; else $data['value'] = $salaries[0]->usalary;
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
										<tr>
											<td><input type="text" name="salaryitems[]" class="form-control" required="required"></td>
											<td><input type="text" name="values[]" class="form-control" placeholder="00.00" maxlength="10" oninput="mytotal()" required="required" /><?php echo ' '.$system->currency; ?></td>
											<td style="text-align:center;"></td>
										</tr>
									</table>
									<table class="table" style="border-style:solid;">
										<tr>
											<td width="65%" style="text-align:center; color:red;" id="totalMessage"></td>
											<td><input type="text" name="total" id="total" class="form-control" readonly><?php echo ' '.$system->currency; ?></td>
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
									<i class="add btn btn-info" id="<?php echo $currentmonth-1; ?>"><?php echo lang('add_salaryitem'); ?></i>
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
										'value' => $salaries[$currentmonth-1]->slbonuse
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
										'value' => $salaries[$currentmonth-1]->slgift
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
										'value' => $salaries[$currentmonth-1]->sldelay
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
										'value' => $salaries[$currentmonth-1]->slvacation
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
										'value' => $salaries[$currentmonth-1]->slsanction
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
										'value' => $salaries[$currentmonth-1]->slabsence
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
										'disabled' => 'disabled',
										'content' => lang('save')
									);
									echo form_button($data);
								?>
								</div>
							</div>
							<?php
								echo form_close();
							?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="add<?php echo $currentmonth-1; ?>" aria-labelledby="add<?php echo $currentmonth-1; ?>-tab">
							add2
						</div>
						</div>
						</div>
						</div>
                      </div>

                    </div>
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->