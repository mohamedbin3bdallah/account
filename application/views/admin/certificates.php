        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('certificates'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 col-md-offset-9 col-sm-offset-9 col-xs-offset-7 form-group top_search">
                  <div class="input-group">
					<?php if(strpos($this->loginuser->privileges, ',cfadd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'addcertificate'"><?php echo lang('add_certificate'); ?></button><?php } ?>
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
                    <?php if(!empty($users)) { ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('name'); ?></th>
						  <th><?php echo lang('username'); ?></th>
						  <th><?php echo lang('title'); ?></th>
						  <th><?php echo lang('certificate'); ?></th>
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('edittime'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',cfedit,') !== false) { ?><th><?php echo lang('edit'); ?></th><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',cfdelete,') !== false) { ?><th><?php echo lang('delete'); ?></th><?php } ?>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($users as $user) { ?>
                        <tr>
                          <td><?php echo $user->uname; ?></td>
						  <td><?php echo $user->username; ?></td>
						  <td><?php echo $user->cftitle; ?></td>
						  <td>
							<?php
								$ext = pathinfo($user->cflink, PATHINFO_EXTENSION); if(strtoupper($ext) == 'PDF') $icon = 'fa fa-file-pdf-o'; elseif(strtoupper($ext) == 'DOC' || strtoupper($ext) == 'DOCX') $icon = 'fa fa-file-word-o'; else $icon = 'fa fa-file-image-o'; { echo '<a href="#" data-toggle="modal" data-target="#show-'.$user->cfid.'"><i class="'.$icon.' fa-2x"></i></a>'; echo '<a href="../'.$user->cflink.'" style="padding-right:20%;" target="_blank">'.lang('download').'</a>'; }
							?>
							<div id="show-<?php echo $user->cfid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo $user->uname.' - '.$user->cftitle; ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<div class="embed-responsive embed-responsive-4by3">
											<?php
												if(strtoupper($ext) == 'PDF') echo '<iframe src="../'.$user->cflink.'" class="embed-responsive-item" frameborder="0"></iframe>';
												elseif(strtoupper($ext) == 'DOC' || strtoupper($ext) == 'DOCX') echo '<iframe src="http://docs.google.com/gview?url=http://pixel4it.net/fanarab/'.$user->cflink.'&embedded=true" class="embed-responsive-item" frameborder="0"></iframe>';
												else echo '<img class="img-responsive" src="../'.$user->cflink.'" width="100%" />';
											?>
											</div>
										</center>
										</div>
									</div>
								</div>
							</div>
						  </td>
						  <td><?php echo $employees[$user->cfuid]; ?></td>
						  <td><?php echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $user->cftime).' , '.date('h:i:s', $user->cftime); if(date('H', $user->cftime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); ?></td>
						  <?php if(strpos($this->loginuser->privileges, ',cfedit,') !== false) { ?><td><a href="<?php echo base_url(); ?>hr/editcertificate/<?php echo $user->cfid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a></td><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',cfdelete,') !== false) { ?><td>
							<i id="<?php echo $user->cfid; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php echo $user->cfid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" id="action_buttom" onclick="location.href = 'deletecertificate/<?php echo $user->cfid; ?>'" data-dismiss="modal"><?php echo lang('yes'); ?></button>
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