		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_bill').' '.$order['oid']; ?></h3>
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
						//echo $admessage;
						echo validation_errors();
						$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
						echo form_open('bills/editbill/'.$order['bid'].'/'.$order['oid'], $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

					<input type="hidden" name="newtotal" value="<?php echo $order['newtotal']; ?>" />
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('code'),'code',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							echo $order['code'];
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('customer'),'customer',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							echo $order['customer'];
						?>
                        </div>
                      </div>
					   <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('info'),'',$data);
						?>
						<div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
							<table id="/*datatable-buttons*/" class="mytable table table-striped table-bordered nowrap"  dir="rtl">
								<?php if(!empty($order['items'])) { ?>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('info'); ?></th>
									<th width="15%" style="text-align:center;"><?php echo lang('quantity'); ?></th>
									<th width="35%" style="text-align:center;"><?php echo lang('price'); ?></th>
								</tr>
								<?php } ?>
								<?php if(!empty($order['items'])) { ?>
								<?php foreach($order['items'] as $item) { ?>
									<tr>
										<td width="50%"><?php if($item['item']) echo $item['item']; else echo $item['joitem']; ?></td>
										<td width="15%"><?php echo $item['quantity']; ?></td>
										<td width="35%"><?php echo $item['price'].' '.$system->currency; ?></td>
									</tr>
								<?php } ?>
								<tr class="danger"><td></td><td></td><td></td></tr>
								<tr class="danger"><td></td><td></td><td></td></tr>
								<tr class="danger"><td></td><td></td><td></td></tr>
								<?php } ?>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('total'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><?php echo $order['total'].' '.$system->currency; ?></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('mustpay'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><?php echo $order['newtotal'].' '.$system->currency; ?></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('discount'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><input type="text" maxlength="25" name="discount" placeholder="00.00" value="<?php echo $order['discount']; ?>" class="form-control" /><?php echo $system->currency; ?></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('payed'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><input type="text" maxlength="25" name="pay" placeholder="00.00" value="<?php echo $order['pay']; ?>" class="form-control" /><?php echo $system->currency; ?></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('rest'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><input type="text" maxlength="25" name="rest" placeholder="00.00" value="<?php echo $order['rest']; ?>" class="form-control" /><?php echo $system->currency; ?></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('paymentmethod'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><select name="paytype" class="form-control"><option value="1" <?php if($order['bpaytype'] == '1') echo 'selected'; ?>><?php echo lang('atm'); ?></option><option value="2" <?php if($order['bpaytype'] == '2') echo 'selected'; ?>><?php echo lang('banktransfer'); ?></option><option value="3" <?php if($order['bpaytype'] == '3') echo 'selected'; ?>><?php echo lang('cash'); ?></option></select></th>
								</tr>
								<tr>
									<th width="50%" style="text-align:center;"><?php echo lang('billtype'); ?></th>
									<th width="15%" style="text-align:center;"></th>
									<th width="35%" style="text-align:center;"><select name="type" class="form-control"><option value="1" <?php if($order['btype'] == '1') echo 'selected'; ?>><?php echo lang('normal'); ?></option><option value="2" <?php if($order['btype'] == '2') echo 'selected'; ?>><?php echo lang('vip'); ?></option></select></th>
								</tr>
							</table>
						</div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('ordernotes'),'onotes',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							echo $order['onotes'];
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
								'class' => 'form-control col-md-7 col-xs-12',
								'value' => $order['bnotes']
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