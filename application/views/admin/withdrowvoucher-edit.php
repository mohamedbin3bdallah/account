		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_withdrowvoucher'); ?></h3>
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
						echo form_open('withdrowvouchers/editwv/'.$withdrowvoucher->wvid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

					<input type="hidden" name="oldorder" value="<?php echo $withdrowvoucher->wvoid; ?>">
					<input type="hidden" name="oldpayment" value="<?php echo $withdrowvoucher->wvtotal; ?>">
                      <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('bill').' <span class="required">*</span>','bill',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<input list="bills" oninput="onInput(this)" id="bill" name="order" maxlength="25" onkeyup="/*showResult(this.value)*/" class="form-control" value="<?php echo $withdrowvoucher->wvoid; ?>" autocomplete="off" required="required"><datalist id="bills"><?php foreach($bills as $bill) { ?><option value="<?php echo $bill->boid; ?>" bill="<?php echo $bill->bid; ?>" customer="<?php echo $bill->customer; ?>" total="<?php echo $bill->btotal; ?>" newtotal="<?php echo $bill->bnewtotal; ?>"><?php echo $bill->ocode.' | '.$bill->customer; ?></option><?php } ?></datalist>
                        </div>
                      </div>
					  <!--<input type="hidden" name="bill" id="bill" value="">-->
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('customer').' <span class="required">*</span>','customer',$data);
						?>
						 <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'customer',
								'id' => 'customer',
								'placeholder' => lang('customer'),
								'class' => 'form-control',
								'readonly' => TRUE,
								'required' => 'required',
								'value' => $withdrowvoucher->customer
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
							echo form_label(lang('total').' <span class="required">*</span>','total',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'newtotal',
								'id' => 'newtotal',
								'placeholder' => lang('total'),
								'class' => 'form-control',
								'readonly' => TRUE,
								'required' => 'required',
								'value' => $withdrowvoucher->total
							);
							echo form_input($data).$system->currency;
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('payment').' <span class="required">*</span>','payment',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'payment',
								'id' => 'payment',
								'placeholder' => '00.00',
								'class' => 'form-control col-md-7 col-xs-12',
								'pattern' => '[-+]?([0-9]*\.[0-9]+|[0-9]+)',
								'title' => 'يجب ان يكون عددا',
								'max' => 255,
								'required' => 'required',
								'value' => $withdrowvoucher->wvtotal
							);
							echo form_input($data).$system->currency;
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('notes'),'notes',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'name' => 'notes',
								'id' => 'notes',
								'placeholder' => lang('notes'),
								'class' => 'form-control',
								'value' => $withdrowvoucher->notes
							);
							echo form_textarea($data);
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
								/*'disabled' => TRUE,*/
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