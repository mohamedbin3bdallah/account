		<!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-left">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php if($this->loginuser->uimage != '' && file_exists($this->loginuser->uimage)) echo base_url().$this->loginuser->uimage; else echo base_url().'imgs/users/user.png'; ?>" alt="<?php echo $this->loginuser->username; ?>"><?php echo $this->loginuser->username; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right" style="text-align:right; float:left;">
                    <!--<li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>-->
					<li><a href="<?php echo base_url(); ?>profile"><i class="fa fa-history pull-left"></i> <?php echo lang('profile'); ?></a></li>
					<li><a href="<?php echo base_url(); ?>account"><i class="fa fa-cog pull-left"></i> <?php echo lang('account'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out pull-left"></i> <?php echo lang('logout'); ?></a></li>
                  </ul>
                </li>
			
			<?php if(isset($unreadNTs) && !empty($unreadNTs)) { ?>
                <li role="presentation" class="dropdown" id="unreadNTs" title="<?php echo lang('notify'); ?>">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o" style="line-height:32px;"></i>
					<?php if($unreadNTs['count']) { ?><span class="badge bg-purple" id="unreadNTsC"><?php echo $unreadNTs['count']; ?></span><?php } unset($unreadNTs['count']); ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php foreach($unreadNTs as $unreadNT) { ?>
					<?php
						$subTime = time() - $unreadNT->time;
						$y = number_format(($subTime/(60*60*24*365)),0);
						$d = number_format(($subTime/(60*60*24))%365,0);
						$h = number_format(($subTime/(60*60))%24,0);
						$m = number_format(($subTime/60)%60,0);
						$unreadNT->ntime = '';
						if($y > 0) $unreadNT->ntime .= $y.' سنة ';
						if($d > 0) $unreadNT->ntime .= $d.' يوم ';
						if($h > 0) $unreadNT->ntime .= $h.' ساعة ';
						if($m > 0) $unreadNT->ntime .= $m.' دقيقة ';
					?>
                    <li dir="rtl" style="float:right;">
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
								قبل <?php echo $unreadNT->ntime; ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">
								<?php echo $unreadNT->user; ?>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 col-md-push-9 col-push-sm-9 col-xs-push-9">
								<img style="margin-top:-20px; width:59px; height:59px;" class="img-circle profile_img" src="<?php if($unreadNT->image != '' && file_exists($unreadNT->image)) echo base_url().$unreadNT->image; else echo base_url().'imgs/users/user.png'; ?>" alt="Profile Image" />
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-3" style="text-align:right;">
								<?php echo $unreadNT->action; ?>
							</div>
						</div>
                    </li>
				  <?php } ?>
                  </ul>
                </li>
			<?php } ?>
			
			<?php if(isset($unreadORs) && !empty($unreadORs)) { ?>
                <li role="presentation" class="dropdown" id="unreadORs" title="<?php echo lang('orders'); ?>">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-files-o" style="line-height:32px;"></i>
					<?php if($unreadORs['count']) { ?><span class="badge bg-blue" id="unreadORsC"><?php echo $unreadORs['count']; ?></span><?php } unset($unreadORs['count']); ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php foreach($unreadORs as $unreadOR) { ?>
					<?php
						$subTime = time() - $unreadOR->time;
						$y = number_format(($subTime/(60*60*24*365)),0);
						$d = number_format(($subTime/(60*60*24))%365,0);
						$h = number_format(($subTime/(60*60))%24,0);
						$m = number_format(($subTime/60)%60,0);
						$unreadOR->ntime = '';
						if($y > 0) $unreadOR->ntime .= $y.' سنة ';
						if($d > 0) $unreadOR->ntime .= $d.' يوم ';
						if($h > 0) $unreadOR->ntime .= $h.' ساعة ';
						if($m > 0) $unreadOR->ntime .= $m.' دقيقة ';
					?>
                    <li dir="rtl" style="float:right;">
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
								قبل <?php echo $unreadOR->ntime; ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">
								<?php echo $unreadOR->user; ?>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 col-md-push-9 col-push-sm-9 col-xs-push-9">
								<img style="margin-top:-20px; width:59px; height:59px;" class="img-circle profile_img" src="<?php if($unreadOR->image != '' && file_exists($unreadOR->image)) echo base_url().$unreadOR->image; else echo base_url().'imgs/users/user.png'; ?>" alt="Profile Image" />
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-3" style="text-align:right;">
								<?php echo $unreadOR->action; ?>
							</div>
						</div>
                    </li>
				  <?php } ?>
                    <li>
                      <div class="text-center">
                        <a href="<?php echo base_url(); ?>orders">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<?php } ?>
				
				<?php if(isset($unreadJOs) && !empty($unreadJOs)) { ?>
                <li role="presentation" class="dropdown" id="unreadJOs" title="<?php echo lang('joborders'); ?>">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-pencil-square-o" style="line-height:32px;"></i>
					<?php if($unreadJOs['count']) { ?><span class="badge bg-green" id="unreadJOsC"><?php echo $unreadJOs['count']; ?></span><?php } unset($unreadJOs['count']); ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php foreach($unreadJOs as $unreadJO) { ?>
					<?php
						$subTime = time() - $unreadJO->time;
						$y = number_format(($subTime/(60*60*24*365)),0);
						$d = number_format(($subTime/(60*60*24))%365,0);
						$h = number_format(($subTime/(60*60))%24,0);
						$m = number_format(($subTime/60)%60,0);
						$unreadJO->ntime = '';
						if($y > 0) $unreadJO->ntime .= $y.' سنة ';
						if($d > 0) $unreadJO->ntime .= $d.' يوم ';
						if($h > 0) $unreadJO->ntime .= $h.' ساعة ';
						if($m > 0) $unreadJO->ntime .= $m.' دقيقة ';
					?>
                    <li dir="rtl" style="float:right;">
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
								قبل <?php echo $unreadJO->ntime; ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">
								<?php echo $unreadJO->user; ?>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 col-md-push-9 col-push-sm-9 col-xs-push-9">
								<img style="margin-top:-20px; width:59px; height:59px;" class="img-circle profile_img" src="<?php if($unreadJO->image != '' && file_exists($unreadJO->image)) echo base_url().$unreadJO->image; else echo base_url().'imgs/users/user.png'; ?>" alt="Profile Image" />
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-3" style="text-align:right;">
								<?php echo $unreadJO->action; ?>
							</div>
						</div>
                    </li>
				  <?php } ?>
                    <li>
                      <div class="text-center">
                        <a href="<?php echo base_url(); ?>joborders/user">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<?php } ?>
				
				<?php if(isset($unreadPVs) && !empty($unreadPVs)) { ?>
                <li role="presentation" class="dropdown" id="unreadPVs" title="<?php echo lang('paymentvouchers'); ?>">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-file-o" style="line-height:32px;"></i>
					<?php if($unreadPVs['count']) { ?><span class="badge bg-orange" id="unreadPVsC"><?php echo $unreadPVs['count']; ?></span><?php } unset($unreadPVs['count']); ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php foreach($unreadPVs as $unreadPV) { ?>
					<?php
						$subTime = time() - $unreadPV->time;
						$y = number_format(($subTime/(60*60*24*365)),0);
						$d = number_format(($subTime/(60*60*24))%365,0);
						$h = number_format(($subTime/(60*60))%24,0);
						$m = number_format(($subTime/60)%60,0);
						$unreadPV->ntime = '';
						if($y > 0) $unreadPV->ntime .= $y.' سنة ';
						if($d > 0) $unreadPV->ntime .= $d.' يوم ';
						if($h > 0) $unreadPV->ntime .= $h.' ساعة ';
						if($m > 0) $unreadPV->ntime .= $m.' دقيقة ';
					?>
                    <li dir="rtl" style="float:right;">
                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                        <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
								<a href="<?php echo base_url(); ?>paymentvouchers/date/<?php echo date('Y-m-d',$unreadPV->time); ?>">قبل <?php echo $unreadPV->ntime; ?></a>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">
								<a href="<?php echo base_url(); ?>paymentvouchers/user/<?php echo $unreadPV->user; ?>"><?php echo $unreadPV->user; ?></a>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 col-md-push-9 col-push-sm-9 col-xs-push-9">
								<img style="margin-top:-20px; width:59px; height:59px;" class="img-circle profile_img" src="<?php if($unreadPV->image != '' && file_exists($unreadPV->image)) echo base_url().$unreadPV->image; else echo base_url().'imgs/users/user.png'; ?>" alt="Profile Image" />
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-3" style="text-align:right;">
								<?php echo $unreadPV->action; ?>
							</div>
						</div>
                    </li>
				  <?php } ?>
                    <li>
                      <div class="text-center">
                        <a href="<?php echo base_url(); ?>paymentvouchers/status">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<?php } ?>
				
				<?php if(isset($unreadBLs) && !empty($unreadBLs)) { ?>
                <li role="presentation" class="dropdown" id="unreadBLs" title="<?php echo lang('bills'); ?>">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-money" style="line-height:32px;"></i>
					<?php if($unreadBLs['count']) { ?><span class="badge bg-red" id="unreadBLsC"><?php echo $unreadBLs['count']; ?></span><?php } unset($unreadBLs['count']); ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php foreach($unreadBLs as $unreadBL) { ?>
					<?php
						$subTime = time() - $unreadBL->time;
						$y = number_format(($subTime/(60*60*24*365)),0);
						$d = number_format(($subTime/(60*60*24))%365,0);
						$h = number_format(($subTime/(60*60))%24,0);
						$m = number_format(($subTime/60)%60,0);
						$unreadBL->ntime = '';
						if($y > 0) $unreadBL->ntime .= $y.' سنة ';
						if($d > 0) $unreadBL->ntime .= $d.' يوم ';
						if($h > 0) $unreadBL->ntime .= $h.' ساعة ';
						if($m > 0) $unreadBL->ntime .= $m.' دقيقة ';
					?>
                    <li dir="rtl" style="float:right;">
                        <div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
								قبل <?php echo $unreadBL->ntime; ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">
								<?php echo $unreadBL->user; ?>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 col-md-push-9 col-push-sm-9 col-xs-push-9">
								<img style="margin-top:-20px; width:59px; height:59px;" class="img-circle profile_img" src="<?php if($unreadBL->image != '' && file_exists($unreadBL->image)) echo base_url().$unreadBL->image; else echo base_url().'imgs/users/user.png'; ?>" alt="Profile Image" />
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-3" style="text-align:right;">
								<?php echo $unreadBL->action; ?>
							</div>
						</div>
                    </li>
				  <?php } ?>
                    <li>
                      <div class="text-center">
                        <a href="<?php echo base_url(); ?>bills">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
				<?php } ?>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->