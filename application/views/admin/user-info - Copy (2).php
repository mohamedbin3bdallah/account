        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('info_user'); ?></h3>
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
                      <ul class="list-unstyled wizard_steps" style="float:right">
                        <li>
                          <a href="#step-10">
                            <span class="step_no"><?php echo lang('salaries'); ?></span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-11">
                            <span class="step_no"><?php echo lang('experiences'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-12">
                            <span class="step_no"><?php echo lang('certificates'); ?></span>
                          </a>
                        </li>
					</ul>
					<ul class="list-unstyled wizard_steps" style="float:right">
						<li>
                          <a href="#step-13">
                            <span class="step_no"><?php echo lang('contracts'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-14">
                            <span class="step_no"><?php echo lang('trainings'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-15">
                            <span class="step_no"><?php echo lang('bonuses'); ?></span>
                          </a>
                        </li>
					</ul>
					<ul class="list-unstyled wizard_steps" style="float:right">
						<li>
                          <a href="#step-16">
                            <span class="step_no"><?php echo lang('gifts'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-17">
                            <span class="step_no"><?php echo lang('sanctions'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-18">
                            <span class="step_no"><?php echo lang('vacations'); ?></span>
                          </a>
                        </li>
					</ul>
					<ul class="list-unstyled wizard_steps" style="float:right">
						<li>
                          <a href="#step-19">
                            <span class="step_no"><?php echo lang('permits'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-20">
                            <span class="step_no"><?php echo lang('errands'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-21">
                            <span class="step_no"><?php echo lang('absences'); ?></span>
                          </a>
                        </li>
					</ul>
					<ul class="list-unstyled wizard_steps" style="float:right">
						<li>
                          <a href="#step-22">
                            <span class="step_no"><?php echo lang('delays'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-23">
                            <span class="step_no"><?php echo lang('covenants'); ?></span>
                          </a>
                        </li>
						<li>
                          <a href="#step-24">
                            <span class="step_no"><?php echo lang('covenants'); ?></span>
                          </a>
                        </li>
                      </ul>

                      <div id="step-10">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('salaryitems'); ?></h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show10" id="show10-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add10" role="tab" id="add10-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="salaryitems" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show10" aria-labelledby="show10-tab">
										show
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add10" aria-labelledby="add10-tab">
										<?php
											//echo $admessage;
											echo validation_errors();
											$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
											echo form_open('users/salaryitem', $attributes);
										?>
										<input type="hidden" name="sleid" value="<?php echo $user->uid; ?>">
										<div class="form-group">
											<?php
												$data = array(
													'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
												);
											echo form_label(lang('salaryitem').' <span class="required">*</span>','salaryitem',$data);
											?>
											<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
											<?php
												$data = array(
													'type' => 'text',
													'name' => 'slitem',
													'id' => 'slitem',
													'placeholder' => lang('salaryitem'),
													'class' => 'form-control col-md-7 col-xs-12',
													//'max' => 255,
													//'required' => 'required',
													'value' => set_value('slitem')
												);
												echo form_input($data);
											?>
											</div>
										</div>
										<div class="form-group">
											<?php
												$data = array(
													'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
												);
											echo form_label(lang('value').' <span class="required">*</span>','value',$data);
											?>
											<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
											<?php
												$data = array(
													'type' => 'text',
													'name' => 'slvalue',
													'id' => 'slvalue',
													'placeholder' => '00.00',
													'class' => 'form-control col-md-7 col-xs-12',
													//'max' => 255,
													//'required' => 'required',
													'value' => set_value('slvalue')
												);
												echo form_input($data);
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
													//'disabled' => 'disabled',
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
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-11">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('experiences'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show11" id="show11-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add11" role="tab" id="add11-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="experiences" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show11" aria-labelledby="show11-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add11" aria-labelledby="add11-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-12">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('certificates'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show11" id="show12-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add12" role="tab" id="add12-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="certificates" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show12" aria-labelledby="show12-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add12" aria-labelledby="add12-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-13">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('contracts'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show13" id="show13-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add13" role="tab" id="add13-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="contracts" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show13" aria-labelledby="show13-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add13" aria-labelledby="add13-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-14">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('trainings'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show14" id="show14-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add14" role="tab" id="add14-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="trainings" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show14" aria-labelledby="show14-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add14" aria-labelledby="add14-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-15">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('bonuses'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show15" id="show15-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add15" role="tab" id="add15-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="bonuses" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show15" aria-labelledby="show15-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add15" aria-labelledby="add15-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-16">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('gifts'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show16" id="show16-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add16" role="tab" id="add16-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="gifts" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show16" aria-labelledby="show16-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add16" aria-labelledby="add16-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-17">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('sanctions'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show17" id="show17-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add17" role="tab" id="add17-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="sanctions" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show17" aria-labelledby="show17-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add17" aria-labelledby="add17-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-18">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('vacations'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show18" id="show18-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add18" role="tab" id="add18-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="vacations" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show18" aria-labelledby="show18-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add18" aria-labelledby="add18-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-19">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('permits'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show19" id="show19-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add19" role="tab" id="add19-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="permits" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show19" aria-labelledby="show19-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add19" aria-labelledby="add19-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-20">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('errands'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show20" id="show20-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add20" role="tab" id="add20-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="errands" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show20" aria-labelledby="show20-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add20" aria-labelledby="add20-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-21">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('absences'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show21" id="show21-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add21" role="tab" id="add21-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="absences" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show21" aria-labelledby="show21-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add21" aria-labelledby="add21-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-22">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('delays'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show22" id="show22-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add22" role="tab" id="add22-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="delays" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show22" aria-labelledby="show22-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add22" aria-labelledby="add22-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-23">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('covenants'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show23" id="show23-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add23" role="tab" id="add23-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="covenants" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show23" aria-labelledby="show23-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add23" aria-labelledby="add23-tab">
										add2
									</div>
								</div>
							</div>
						</div>
                      </div>
					  <div id="step-24">
                        <h2 class="StepTitle" style="text-align:center;"><?php echo lang('covenants'); ?></h2>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active" style="float:right;"><a href="#show24" id="show24-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('show'); ?></a></li>
									<li role="presentation" class="" style="float:right;"><a href="#add24" role="tab" id="add24-tab" data-toggle="tab" aria-expanded="false"><?php echo lang('add'); ?></a></li>
								</ul>
								<div id="covenants" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="show24" aria-labelledby="show24-tab">
										show2
									</div>
									<div role="tabpanel" class="tab-pane fade" id="add24" aria-labelledby="add24-tab">
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