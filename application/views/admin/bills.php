        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('bills'); ?></h3>
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
                    <?php if(!empty($orders)) { $staarr = array(array('class'=>'danger','output'=>lang('reject')),array('class'=>'success','output'=>lang('done')),array('class'=>'warning','output'=>lang('warning')),array('class'=>'info','output'=>lang('new')),array('class'=>'danger','output'=>lang('waiting')),array('class'=>'danger','output'=>lang('finishtime'))); ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('number'); ?></th>
						  <th><?php echo lang('code'); ?></th>
						  <th><?php echo lang('code').' '.lang('bill'); ?></th>
						  <th width="10%"><?php echo lang('edittime'); ?></th>
						  <th></th>
						  <th><?php echo lang('customer'); ?></th>
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('status'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',bprint,') !== false) { ?><th><?php echo lang('print'); ?></th><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',bedit,') !== false) { ?><th><?php echo lang('edit'); ?></th><?php } ?>
						  <!--<th><?php //echo lang('delete'); ?></th>-->
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($orders as $order) { ?>
                        <tr>
                          <td><?php echo $order['oid']; ?></td>
						  <td><?php echo $order['ocode']; ?></td>
						  <td><?php echo $order['code']; ?></td>
						  <td width="10%"><?php if($order['btime']){ echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $order['btime']).' , '.date('h:i:s', $order['btime']); if(date('H', $order['btime']) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); } ?></td>
						  <td>
						   <a class="" href="#" data-toggle="modal" data-target="#det-<?php echo $order['bid']; ?>"><?php echo lang('details'); ?></a>
						   <div id="det-<?php echo $order['bid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<br>
        								</div>
										<div class="modal-body">
											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="rtl">
												<?php if(!empty($order['items'])) { ?>
												<thead>
													<tr>
														<td><?php echo lang('info'); ?></td>
														<td><?php echo lang('quantity'); ?></td>
														<td><?php echo lang('price'); ?></td>
													</tr>
												</thead>
												<?php } ?>
												<tbody>
												<?php if(!empty($order['items'])) { ?>
												<?php foreach($order['items'] as $item) { ?>
													<tr>
														<td><?php if($item['item']) echo $item['item']; else echo $item['joitem']; ?></td>
														<td><?php echo $item['quantity']; ?></td>
														<td><?php echo $item['price'].' '.$system->currency; ?></td>
													</tr>
												<?php } ?>
													<tr class="danger"><td></td><td></td><td></td></tr>
													<tr class="danger"><td></td><td></td><td></td></tr>
													<tr class="danger"><td></td><td></td><td></td></tr>
												<?php } ?>
													<tr>
														<td><?php echo lang('total'); ?></td>
														<td></td>
														<td><?php echo $order['total'].' '.$system->currency; ?></td>
													</tr>
													<tr>
														<td><?php echo lang('mustpay'); ?></td>
														<td></td>
														<td><?php echo number_format(($order['newtotal']-$order['discount']),2).' '.$system->currency; ?></td>
													</tr>
													<tr>
														<td><?php echo lang('discount'); ?></td>
														<td></td>
														<td><?php if($order['discount']) echo $order['discount'].' '.$system->currency; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						  </td>
						  <td><?php echo $order['customer']; ?></td>
						  <td><?php echo $order['employee']; ?></td>
						  <td>
							<div class="alert-<?php echo $staarr[$order['accept']]['class']; ?> fade in" role="alert" style="text-align:center;">
								<strong><?php echo $staarr[$order['accept']]['output']; ?></strong>
							</div>
						  </td>
						  <?php if(strpos($this->loginuser->privileges, ',bprint,') !== false) { ?><td><?php if($order['accept'] == '1') { ?><a href="<?php echo base_url(); ?>bills/pdf/<?php echo $order['bid']; ?>" target="_blank"><?php echo lang('print'); ?></a><?php } ?></td><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',bedit,') !== false) { ?><td><?php if($order['accept'] == '3') { ?><a href="<?php echo base_url(); ?>bills/edit/<?php echo $order['bid']; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a><?php } ?></td><?php } ?>
						  <!--<td>
						    <?php //if($order['accept'] == '3') { ?>
							<i id="<?php //echo $order['oid']; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php //echo $order['oid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php //echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" onclick="location.href = 'orders/del/<?php //echo $order['oid']; ?>'" data-dismiss="modal"><?php //echo lang('yes'); ?></button>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php //echo lang('no'); ?></button>
										</center>
										</div>
									</div>
								</div>
							</div>
							<?php //} ?>
						 </td>-->
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