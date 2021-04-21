        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('joborders'); ?></h3>
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
                    <!--<p class="text-muted font-13 m-b-30">
                      The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                    </p>-->
                    <?php if(!empty($orders)) { $staarr = array(array('class'=>'danger','output'=>lang('reject')),array('class'=>'success','output'=>lang('done')),array('class'=>'warning','output'=>lang('warning')),array('class'=>'info','output'=>lang('new')),array('class'=>'danger','output'=>lang('waiting')),array('class'=>'danger','output'=>lang('finishtime'))); ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('number'); ?></th>
						  <th><?php echo lang('ordernumber'); ?></th>
						  <th><?php echo lang('code'); ?></th>
						  <th width="10%"><?php echo lang('edittime'); ?></th>
						  <th width="10%"><?php echo lang('endtime'); ?></th>
						  <th><?php echo lang('info'); ?></th>
						  <th><?php echo lang('quantity'); ?></th>
						  <th><?php echo lang('follower'); ?></th>
						  <th><?php echo lang('employee'); ?></th>
						  <th><?php echo lang('status'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',joorder,') !== false) { ?><th><?php echo lang('edit'); ?></th><?php } ?>
						  <!--<th><?php //echo lang('delete'); ?></th>-->
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($orders as $order) { ?>
                        <tr class="<?php if($order['endtime'] < time() && $order['accept'] != '1') echo 'danger'; ?>">
                          <td><?php echo $order['joid']; ?></td>
						  <td><?php echo $order['oid']; ?></td>
						  <td><?php echo $order['ocode']; ?></td>
						  <td width="10%"><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $order['time']).' , '.date('h:i:s', $order['time']); if(date('H', $order['time']) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td width="10%"><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $order['endtime']).' , '.date('h:i:s', $order['endtime']); if(date('H', $order['endtime']) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td><?php if($order['item']) echo $order['item']; else echo $order['joitem']; ?></td>
						  <td><?php echo $order['quantity']; ?></td>
						  <td><?php if(!empty($users) && isset($users[$order['follower']])) echo $users[$order['follower']]; ?></td>
						  <td><?php if(!empty($users) && isset($users[$order['employee']])) echo $users[$order['employee']]; ?></td>
						  <td>
							<div class="alert-<?php echo $staarr[$order['accept']]['class']; ?> fade in" role="alert" style="text-align:center;">
								<strong><?php echo $staarr[$order['accept']]['output']; ?></strong>
							</div>
						  </td>
						  <?php if(strpos($this->loginuser->privileges, ',joorder,') !== false) { ?><td><?php if($order['accept'] == '3' && $order['endtime'] > time()) { ?><a href="<?php echo base_url(); ?>joborders/edit/<?php echo $order['joid']; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a><?php } ?></td><?php } ?>
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