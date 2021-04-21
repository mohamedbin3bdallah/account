        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('items'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<?php if(strpos($this->loginuser->privileges, ',iadd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'items/add'"><?php echo lang('add_item'); ?></button><?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row"  dir="rtl">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>Button Example <small>sections</small></h2>-->
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
                    <?php if(!empty($items)) { ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
						  <th><?php echo lang('name'); ?></th>
						  <th><?php echo lang('bill'); ?></th>
						  <th><?php echo lang('type'); ?></th>
						  <th><?php echo lang('model'); ?></th>
						  <!--<th><?php echo lang('delegate'); ?></th>
						  <th><?php echo lang('buyprice'); ?></th>
						  <th><?php echo lang('wholesaleprice'); ?></th>
						  <th><?php echo lang('retailprice'); ?></th>-->
						  <th></th>
						  <th width="25%"><?php echo lang('range'); ?></th>
						  <th><?php echo lang('quantity'); ?></th>
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('edittime'); ?></th>
						  <th></th>
						  <th></th>
						  <th></th>
						  <th><?php echo lang('active'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',iedit,') !== false) { ?><th><?php echo lang('edit'); ?></th><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',idelete,') !== false) { ?><th><?php echo lang('delete'); ?></th><?php } ?>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($items as $item) { ?>
                        <tr>
                          <td><?php echo $item->iname; ?></td>
						  <td><?php echo $item->bin; ?></td>
						  <td><?php echo $item->type; ?></td>
						  <td><?php echo $item->model; ?></td>
						  <!--<td><?php echo $item->delegate; ?></td>
						  <td><?php echo $item->ibuyprice; ?></td>
						  <td><?php echo $item->iwholesaleprice; ?></td>
						  <td><?php echo $item->iretailprice; ?></td>-->
						  <td>
						   <a class="" href="#" data-toggle="modal" data-target="#det-<?php echo $item->iid; ?>"><?php echo lang('details'); ?></a>
						   <div id="det-<?php echo $item->iid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<br>
        								</div>
										<div class="modal-body">
											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="rtl">
												<tr>
													<td><?php echo lang('delegate'); ?></td>
													<td><?php echo $item->delegate; ?></td>
												</tr>
												<tr>
													<td><?php echo lang('buyprice'); ?></td>
													<td><?php echo $item->ibuyprice.' '.$system->currency; ?></td>
												</tr>
												<tr>
													<td><?php echo lang('wholesaleprice'); ?></td>
													<td><?php echo $item->iwholesaleprice.' '.$system->currency; ?></td>
												</tr>
												<tr>
													<td><?php echo lang('retailprice'); ?></td>
													<td><?php echo $item->iretailprice.' '.$system->currency; ?></td>
												</tr>
												<tr>
													<td><?php echo lang('code'); ?></td>
													<td><img src="<?php echo base_url(); ?>barcode/barcode.php?codetype=Code39&size=55&text=<?php echo $item->icode; ?>&print=true" /></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						  </td>
						  <td width="25%">
							<div class="progress right">
								<!--<div class="progress-bar progress-bar-danger" data-transitiongoal="25" aria-valuenow="25" style="float:right; width:25%;"></div>-->
								<div class="progress-bar progress-bar-<?php if($item->iquantity > ($item->imaxrange/2)) echo 'success'; elseif($item->iquantity > $item->iminrange) echo 'warning'; else echo 'danger'; ?>" data-transitiongoal="<?php echo (($item->iquantity*100)/$item->imaxrange); ?>"></div>
							</div>
						  </td>
						  <td><?php echo $item->iquantity; ?></td>
						  <td><?php echo $employees[$item->iuid]; ?></td>
						  <td><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $item->ictime).' , '.date('h:i:s', $item->ictime); if(date('H', $item->ictime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <td>
						  <?php if($item->iprint != '') { ?>
						   <a class="" href="#" data-toggle="modal" data-target="#ped-<?php echo $item->iid; ?>"><?php echo lang('printed'); ?></a>
						   <div id="ped-<?php echo $item->iid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<br>
        								</div>
										<div class="modal-body">
											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="rtl">
												<tr>
													<td><?php echo lang('codes'); ?></td>
													<td><?php echo $item->icode.'NO'.str_replace(',', ' , '.$item->icode.'NO', $item->iprint); ?></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						  </td>
						  <td>
						   <?php if($item->inprint != '') { ?>
						   <a class="" href="#" data-toggle="modal" data-target="#nped-<?php echo $item->iid; ?>"><?php echo lang('nprinted'); ?></a>
						   <div id="nped-<?php echo $item->iid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<br>
        								</div>
										<div class="modal-body">
											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="rtl">
												<tr>
													<td><?php echo lang('codes'); ?></td>
													<td><?php echo $item->icode.'NO'.str_replace(',', ' , '.$item->icode.'NO', $item->inprint); ?></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						  </td>
						  <td>
						  <?php if($item->inprint != '') { ?>
						   <a class="" href="#" data-toggle="modal" data-target="#print-<?php echo $item->iid; ?>"><?php echo lang('print'); ?></a>
						   <div id="print-<?php echo $item->iid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content" style="height:777px;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<br>
        								</div>
										<div class="modal-body">
											<?php $attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left', 'target' => '_blank'); echo form_open('items/iprint/'.$item->iid, $attributes); ?>
											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="rtl">
												<tr style="height:555px;">
													<td><?php echo lang('codes'); ?></td>
													<td><?php $itemcodes = explode(',',$item->inprint); ?><select name="codes[]" class="form-control multiuserselect" required="required" multiple><?php for($np=0;$np<count($itemcodes);$np++) { ?><option value="<?php echo $itemcodes[$np]; ?>"><?php echo $item->icode.'NO'.$itemcodes[$np]; ?></option><?php } ?></select></td>
												</tr>
												<tr>
													<td></td>
													<td>
														<?php																				
														$data = array(
															'name' => 'submit',
															'id' => 'submit',
															'class' => 'btn btn-success',
															'value' => 'true',
															'type' => 'submit',
															'content' => lang('print')
														);
														echo form_button($data);
														?>
													</td>
												</tr>
											</table>
											<?php echo form_close(); ?>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						  </td>
                          <td><input type="checkbox" <?php if($item->active == 1) echo 'checked'; ?> disabled></td>
						  <?php if(strpos($this->loginuser->privileges, ',iedit,') !== false) { ?><td><a href="<?php echo base_url(); ?>items/edit/<?php echo $item->iid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a></td><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',idelete,') !== false) { ?><td>
							<i id="<?php echo $item->iid; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php echo $item->iid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" id="action_buttom" onclick="location.href = 'items/del/<?php echo $item->iid; ?>'" data-dismiss="modal"><?php echo lang('yes'); ?></button>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
										</center>
										</div>
									</div>
								</div>
							</div>
						</td><?php } ?>
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