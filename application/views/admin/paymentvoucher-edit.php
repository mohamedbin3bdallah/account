		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_paymentvoucher'); ?></h3>
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
						echo form_open_multipart('paymentvouchers/editpaymentvoucher/'.$paymentvoucher->pvid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('type').' <span class="required">*</span>','type',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							$ourtypes1[''] = lang('select');
							foreach($itemtypes as $itemtype)
							{
								$ourtypes1[$itemtype->itid] = $itemtype->itname;
							}											
							echo form_dropdown('type', $ourtypes1, array('type'=>$paymentvoucher->typeid), 'id="type" class="form-control" required="required"');
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('model').' <span class="required">*</span>','model',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							if(!empty($itemmodels))
							{
								$ourtypes1[''] = lang('select');
								foreach($itemmodels as $itemmodel)
								{
									$ourtypes2[$itemmodel->imid] = $itemmodel->imname;
								}											
								echo form_dropdown('model', $ourtypes2, array('model'=>$paymentvoucher->modelid), 'id="model" class="form-control" required="required"');
							}
							else
							{
						?>
								<select name="model" id="model" class="form-control" required="required">
								</select>
							<?php } ?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('item').' <span class="required">*</span>','item',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							/*if(!empty($items))
							{
								foreach($items as $item)
								{
									$ourtypes3[$item->iid] = $item->iname;
								}											
								echo form_dropdown('item', $ourtypes3, array('item'=>$paymentvoucher->pviid), 'id="item" class="form-control" required="required"');
							}
							else
							{*/
						?>
								<select name="item" id="item" class="form-control" required="required">
									<option value=""><?php echo lang('select'); ?></option>
									<?php
									if(!empty($items)) {
										foreach($items as $item) { ?>
											<option value="<?php echo $item->iid; ?>" quantity="<?php echo $item->iquantity; ?>" <?php if($item->iid == $paymentvoucher->pviid) echo 'selected'; ?>><?php echo $item->iname; ?></option>									
									<?php } } ?>
								</select>
							<?php //} ?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('quantity').' <span class="required">*</span>','quantity',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'number',
								'name' => 'quantity',
								'id' => 'quantity',
								'placeholder' => lang('quantity'),
								'class' => 'form-control col-md-7 col-xs-12',
								'min' => 1,
								'max' => ($paymentvoucher->pvquantity)+($paymentvoucher->iquantity),
								'step' => 1,
								/*'pattern' => '[0-9]{1,}',
								'title' => 'must be quantity',*/
								'required' => 'required',
								/*'readonly' => TRUE,*/
								'value' => $paymentvoucher->pvquantity
							);
							echo form_input($data);
						?>
                        </div>
                      </div>
					  <!--<div class="form-group">
                        <?php
							/*$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('active'),'active',$data);*/
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							/*$data = array(
								'name' => 'active',
								'id' => 'active',
								'checked' => 'TRUE',
								'class' => 'js-switch',
								'value' => 1
							);
							echo form_checkbox($data);*/
						?>
                        </div>
                      </div>-->
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