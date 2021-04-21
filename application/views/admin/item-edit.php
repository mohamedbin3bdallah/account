		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_item'); ?></h3>
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
						echo form_open_multipart('items/edititem/'.$item->iid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->
					<input type="hidden" name="oldquantity" value="<?php echo $item->iquantity; ?>" />
					<input type="hidden" name="oldtquantity" value="<?php echo $item->itquantity; ?>" />
					<input type="hidden" name="oldnprint" value="<?php echo $item->inprint; ?>" />

					<div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('name').' <span class="required">*</span>','name',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'name',
								'id' => 'name',
								'placeholder' => lang('name'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 255,
								//'required' => 'required',
								'value' => $item->iname
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
							echo form_label(lang('bill').' <span class="required">*</span>','bill',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'bill',
								'id' => 'bill',
								'placeholder' => lang('bill'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 50,
								//'required' => 'required',
								'value' => $item->bin
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
							echo form_label(lang('type').' <span class="required">*</span>','type',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							//$ourtypes1[''] = lang('select');
							foreach($itemtypes as $itemtype)
							{
								$ourtypes1[$itemtype->itid] = $itemtype->itname;
							}											
							echo form_dropdown('type', $ourtypes1, array('type'=>$item->iitid), 'id="type" class="form-control"');
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
							/*if(!empty($itemmodels))
							{*/
								foreach($itemmodels as $itemmodel)
								{
									$ourtypes2[$itemmodel->imid] = $itemmodel->imname;
								}											
								echo form_dropdown('model', $ourtypes2, array('model'=>$item->iimid), 'id="model" class="form-control"');
							/*}
							else
							{*/
						?>
								<!--<select name="model" id="model" class="form-control" required="required">
								</select>-->
							<?php //} ?>
                        </div>
                      </div>
					  <!--<div class="form-group">
						<?php
							/*$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('code').' <span class="required">*</span>','code',$data);*/
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							/*$data = array(
								'type' => 'text',
								'name' => 'code',
								'id' => 'code',
								'placeholder' => lang('code'),
								'class' => 'form-control col-md-7 col-xs-12',
								'max' => 255,
								'required' => 'required',
								'value' => $item->icode
							);
							echo form_input($data);*/
						?>
                        </div>
                      </div>-->
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('delegate').' <span class="required">*</span>','delegate',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							if(!empty($delegates))
							{
								foreach($delegates as $delegate)
								{
									$ourtypes3[$delegate->did] = $delegate->dname;
								}											
								echo form_dropdown('delegate', $ourtypes3, array('delegate'=>$item->idid), 'class="form-control"');
							}
							else echo lang('no_data');
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('buyprice').' <span class="required">*</span>','buyprice',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'buyprice',
								'id' => 'buyprice',
								'placeholder' => '00.00',
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 11,
								//'required' => 'required',
								'value' => $item->ibuyprice
							);
							echo form_input($data);
							echo $system->currency;
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('wholesaleprice').' <span class="required">*</span>','wholesaleprice',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'wholesaleprice',
								'id' => 'wholesaleprice',
								'placeholder' => '00.00',
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 11,
								//'required' => 'required',
								'value' => $item->iwholesaleprice
							);
							echo form_input($data);
							echo $system->currency;
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('retailprice').' <span class="required">*</span>','retailprice',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'retailprice',
								'id' => 'retailprice',
								'placeholder' => '00.00',
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 11,
								//'required' => 'required',
								'value' => $item->iretailprice
							);
							echo form_input($data);
							echo $system->currency;
						?>
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
								'min' => $item->iquantity,
								//'max' => 1000000000,
								//'step' => 1,
								/*'pattern' => '[0-9]{1,}',
								'title' => 'must be quantity',*/
								//'required' => 'required',
								'value' => $item->iquantity
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
							echo form_label(lang('minrange').' <span class="required">*</span>','minrange',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'number',
								'name' => 'minrange',
								'id' => 'minrange',
								'placeholder' => lang('minrange'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'min' => 1,
								//'max' => 1000000000,
								//'step' => 1,
								/*'pattern' => '[0-9]{1,}',
								'title' => 'must be minrange',*/
								//'required' => 'required',
								'value' => $item->iminrange
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
							echo form_label(lang('maxrange').' <span class="required">*</span>','maxrange',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'number',
								'name' => 'maxrange',
								'id' => 'maxrange',
								'placeholder' => lang('maxrange'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'min' => 1,
								//'max' => 1000000000,
								//'step' => 1,
								/*'pattern' => '[0-9]{1,}',
								'title' => 'must be maxrange',*/
								//'required' => 'required',
								'value' => $item->imaxrange
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
							echo form_label(lang('active'),'active',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'name' => 'active',
								'id' => 'active',
								/*'checked' => 'TRUE',*/
								'class' => 'js-switch',
								'value' => 1
							);
							if($item->active == '1') $data['checked'] = 'TRUE';
							echo form_checkbox($data);
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