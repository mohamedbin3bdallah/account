		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_accpaymentvoucher'); ?></h3>
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
						echo form_open('accpaymentvouchers/editapv/'.$order['apvid'], $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

                      <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-2 col-md-push-10 col-sm-2 col-sm-push-10 col-xs-12'
							);
							echo form_label(lang('branch').' <span class="required">*</span>','branch',$data);
						?>
                        <div class="col-md-10 col-md-pull-2 col-sm-10 col-sm-pull-2 col-xs-12">
						<?php
							$ourtypes[''] = lang('select');
							if(!empty($branches))
							{
								foreach($branches as $branch)
								{
									$ourtypes[$branch->bcid] = $branch->bcname;
								}											
							}
							echo form_dropdown('branch', $ourtypes, array('branch'=>$order['apvbcid']), 'id="branch" class="form-control" required="required"');
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-2 col-md-push-10 col-sm-2 col-sm-push-10 col-xs-12'
							);
							echo form_label(lang('customer').' <span class="required">*</span>','customer',$data);
						?>
                        <div class="col-md-10 col-md-pull-2 col-sm-10 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'customer',
								'id' => 'customer',
								'placeholder' => lang('customer'),
								'class' => 'form-control col-md-7 col-xs-12',
								'max' => 255,
								'required' => 'required',
								'value' => $order['customer']
							);
							echo form_input($data);
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-2 col-md-push-10 col-sm-2 col-sm-push-10 col-xs-12'
							);
							echo form_label(lang('info'),'',$data);
						?>
						<div class="col-md-10 col-md-pull-2 col-sm-10 col-sm-pull-2 col-xs-12">
							<table id="/*datatable-buttons*/" class="mytable table table-striped table-bordered nowrap"  dir="rtl">
								<tr>
									<th width="45%" style="text-align:center;"><?php //echo lang('item'); ?></th>
									<th width="25%" style="text-align:center;"><?php echo lang('price'); ?></th>
									<th width="25%" style="text-align:center;"><?php echo lang('quantity'); ?></th>
									<th width="5%" style="text-align:center;"></th>
								</tr>
								<!--<tr><td><select name="item[]" class="form-control" required="required"><?php foreach($items as $item) { ?><option value="<?php echo $item->iid; ?>"><?php echo $item->iname; ?></option><?php } ?></select></td><td><input type="text" name="price[]" class="form-control" placeholder="00.00" maxlength="10" required="required"/></td><td><input type="number" name="quantity[]" class="form-control" placeholder="الكمية" min="1" max="999" required="required" /></td><td></td></tr>-->
								<?php $count = 0; foreach($order['items'] as $key => $item) { ?>
									<tr><td><input type="text" name="item[]" maxlength="255" class="form-control" value="<?php echo $item['item']; ?>" required="required"></td><td><input type="text" name="price[]" class="form-control" placeholder="00.00" maxlength="10" oninput="mytotal()" value="<?php echo $item['price']; ?>" required="required" /><?php echo ' '.$system->currency; ?></td><td><input type="number" name="quantity[]" class="form-control" placeholder="الكمية" min="1" maxlength="10" value="<?php echo $item['quantity']; ?>" required="required" oninput="/*onQuantity(this)*/" /></td><td><?php if($count != 0) { ?><i class="delete glyphicon glyphicon-remove"></i><?php } ?></td></tr>
								<?php $count = $count + 1; } ?>
							</table>
							<table class="table" style="border-style:solid;">
								<tr>
									<td width="45%" style="text-align:center;"><?php echo lang('total'); ?></td>
									<td><input type="text" name="total" id="total" class="form-control" value="<?php echo $order['total']; ?>" readonly><?php echo ' '.$system->currency; ?></td>
								</tr>
							</table>
						</div>
                      </div>
					  <div class="form-group">
                        <?php
							$data = array(
								'class' => 'control-label col-md-2 col-md-push-10 col-sm-2 col-sm-push-10 col-xs-12'
							);
							echo form_label(' ','',$data);
						?>
                        <div class="col-md-10 col-md-pull-2 col-sm-10 col-sm-pull-2 col-xs-12">
							<i class="add btn btn-info"><?php echo lang('add'); ?></i>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-2 col-md-push-10 col-sm-2 col-sm-push-10 col-xs-12'
							);
							echo form_label(lang('notes'),'notes',$data);
						?>
                        <div class="col-md-10 col-md-pull-2 col-sm-10 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'name' => 'notes',
								'id' => 'notes',
								'placeholder' => lang('notes'),
								'class' => 'form-control',
								'value' => $order['notes']
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