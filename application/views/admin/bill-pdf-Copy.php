		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('pdf_bill').' '.$order['oid']; ?></h3>
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

				  <?php
					$paymentmethod = array(1=>lang('atm'),2=>lang('banktransfer'),3=>lang('cash'));
					$billtype = array(1=>lang('normal'),2=>lang('vip'));
				  ?>
					<div class="row">
						<div class="col-xs-12 table">
                          <table class="table table-striped">
							  <tr>
                                <th><?php echo lang('number').' '.lang('bill'); ?></th>
                                <td><?php echo $order['oid']; ?></td>
								<th><?php echo lang('code'); ?></th>
                                <td><?php echo $order['ocode']; ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('day'); ?></th>
                                <td><?php echo date('Y-m-d', $order['btime']); ?></td>
								<th><?php echo lang('time'); ?></th>
                                <td><?php echo date('h:i:sa', $order['btime']); ?></td>
                              </tr>
							  <tr></tr>
                              <tr>
                                <th><?php echo lang('customer'); ?></th>
                                <td><?php echo $order['customer']; ?></td>
								<th><?php echo lang('phone'); ?></th>
                                <td><?php echo $order['cphone']; ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('paymentmethod'); ?></th>
                                <td><?php echo $paymentmethod[$order['bpaytype']]; ?></td>
								<th><?php echo lang('billtype'); ?></th>
                                <td><?php echo $billtype[$order['btype']]; ?></td>
                              </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
					  
				  <?php if(!empty($order['items'])) { ?>
					<div class="row">
						<div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th width="15%"><?php echo lang('code'); ?></th>
                                <th width="47%"><?php echo lang('name').' '.lang('item'); ?></th>
                                <th><?php echo lang('quantity'); ?></th>
                                <th><?php echo lang('price'); ?></th>
                              </tr>
                            </thead>
                            <tbody>
							<?php for($it=0;$it<count($order['items']);$it++) { ?>
                              <tr>
                                <td width="15%"><?php echo $order['items'][$it]['icode']; ?></td>
                                <td width="47%"><?php echo $order['items'][$it]['item']; ?></td>
                                <td><?php echo $order['items'][$it]['quantity']; ?></td>
                                <td><?php echo $order['items'][$it]['price']; ?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
				  <?php } ?>
				  
					<div class="row">
						<div class="col-xs-5">
                          <table class="table table-striped">
                              <tr>
                                <th><?php echo lang('total'); ?></th>
                                <td><?php echo number_format(($order['total']-$order['discount']),2); ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('discount'); ?></th>
                                <td><?php echo $order['discount']; ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('payed'); ?></th>
                                <td><?php echo $order['pay']; ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('rest'); ?></th>
                                <td><?php echo $order['rest']; ?></td>
                              </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
				  
					<div class="row">
						<div class="col-xs-12 table">
                          <table class="table table-striped">
                              <tr>
                                <th><?php echo lang('employee'); ?></th>
                                <td><?php echo $order['employee']; ?></td>
                              </tr>
							  <tr>
                                <th><?php echo lang('phone'); ?></th>
                                <td><?php echo $order['phone']; ?></td>
                              </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
					  
                  </div>
                </div>
              </div>
            </div>
		  </div>
        </div>