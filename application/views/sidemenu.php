        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>home" class="site_title"><span><?php echo $system->website; ?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic ">
                <img src="<?php if($this->loginuser->uimage != '' && file_exists($this->loginuser->uimage)) echo base_url().$this->loginuser->uimage; else echo base_url().'imgs/users/user.png'; ?>" alt="<?php echo $this->loginuser->username; ?>" class="img-circle profile_img" style="max-height:55px;">
              </div>
              <div class="profile_info">
                <span><?php echo lang('welcome'); ?>,</span>
                <h2><?php echo $this->loginuser->username; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

			<br>
			<br>
			<br>
			<br>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!--<h3>General</h3>-->
                <ul class="nav side-menu" style="text-align:right;">
				  <?php if($this->loginuser->uutid ==  '1') { ?><li><a href="<?php echo base_url(); ?>systemy"><?php echo lang('system'); ?><i class="fa fa-cog"></i></a></li><?php } ?>
				  
				  <?php if(strpos($this->loginuser->privileges, ',utadd,') !== false || strpos($this->loginuser->privileges, ',utsee,') !== false || strpos($this->loginuser->privileges, ',uadd,') !== false || strpos($this->loginuser->privileges, ',usee,') !== false) { ?>
				  <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('users'); ?> <i class="fa fa-user"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',utadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>usertypes/add"><?php echo lang('add_usertype'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',utsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>usertypes"><?php echo lang('usertypes'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',uadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>users/add"><?php echo lang('add_user'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',usee,') !== false) { ?><li><a href="<?php echo base_url(); ?>users"><?php echo lang('users'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>
				  
				   <?php if(strpos($this->loginuser->privileges, ',sledit,') !== false || strpos($this->loginuser->privileges, ',slsee,') !== false || strpos($this->loginuser->privileges, ',cvedit,') !== false || strpos($this->loginuser->privileges, ',cvsee,') !== false || strpos($this->loginuser->privileges, ',tredit,') !== false || strpos($this->loginuser->privileges, ',trsee,') !== false || strpos($this->loginuser->privileges, ',cfedit,') !== false || strpos($this->loginuser->privileges, ',cfsee,') !== false || strpos($this->loginuser->privileges, ',exedit,') !== false || strpos($this->loginuser->privileges, ',exsee,') !== false) { ?>
				  <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('hr'); ?> <i class="fa fa-user"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',slsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>hr/salaries"><?php echo lang('salaries'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',cfsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>hr/certificates"><?php echo lang('certificates'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',exsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>hr/experiences"><?php echo lang('experiences'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',trsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>hr/trainings"><?php echo lang('trainings'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',cvsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>hr/covenants"><?php echo lang('covenants'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>
				  
				  <?php if(strpos($this->loginuser->privileges, ',bcadd,') !== false || strpos($this->loginuser->privileges, ',bcsee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('branches'); ?> <i class="fa fa-tree"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',bcadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>branches/add"><?php echo lang('add_branch'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',bcsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>branches"><?php echo lang('branches'); ?></a></li><?php } ?>
					</ul>
				   </li>
				   <?php } ?>
				   
				   <?php if(strpos($this->loginuser->privileges, ',cadd,') !== false || strpos($this->loginuser->privileges, ',csee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('customers'); ?> <i class="fa fa-gift"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',cadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>customers/add"><?php echo lang('add_customer'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',csee,') !== false) { ?><li><a href="<?php echo base_url(); ?>customers"><?php echo lang('customers'); ?></a></li><?php } ?>
					</ul>
				   </li>
				   <?php } ?>

				   <?php if(strpos($this->loginuser->privileges, ',dadd,') !== false || strpos($this->loginuser->privileges, ',dsee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('delegates'); ?> <i class="fa fa-male"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',dadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>delegates/add"><?php echo lang('add_delegate'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',dsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>delegates"><?php echo lang('delegates'); ?></a></li><?php } ?>
					</ul>
				   </li>
				   <?php } ?>

				   <?php if(strpos($this->loginuser->privileges, ',itadd,') !== false || strpos($this->loginuser->privileges, ',itsee,') !== false || strpos($this->loginuser->privileges, ',imadd,') !== false || strpos($this->loginuser->privileges, ',imsee,') !== false || strpos($this->loginuser->privileges, ',iadd,') !== false || strpos($this->loginuser->privileges, ',isee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('itemtypes').' | '.lang('items'); ?> <i class="fa fa-dropbox"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',itadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>itemtypes/add"><?php echo lang('add_itemtype'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',itsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>itemtypes"><?php echo lang('itemtypes'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',imadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>itemmodels/add"><?php echo lang('add_itemmodel'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',imsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>itemmodels"><?php echo lang('itemmodels'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',iadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>items/add"><?php echo lang('add_item'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',isee,') !== false) { ?><li><a href="<?php echo base_url(); ?>items"><?php echo lang('items'); ?></a></li><?php } ?>
					</ul>
				   </li>
				   <?php } ?>

				   <?php if(strpos($this->loginuser->privileges, ',oadd,') !== false || strpos($this->loginuser->privileges, ',osee,') !== false) { ?>
				  <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('orders'); ?> <i class="fa fa-files-o"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',oadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>orders/add"><?php echo lang('add_order'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',osee,') !== false) { ?><li><a href="<?php echo base_url(); ?>orders"><?php echo lang('orders'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>
				  
				  <?php if(strpos($this->loginuser->privileges, ',joorder,') !== false || strpos($this->loginuser->privileges, ',josee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('joborders'); ?> <i class="fa fa-pencil-square-o"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',joorder,') !== false) { ?><li><a href="<?php echo base_url(); ?>joborders"><?php echo lang('jobordersorder'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',josee,') !== false) { ?><li><a href="<?php echo base_url(); ?>joborders/user"><?php echo lang('joborders'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>
				  
				  <?php if(strpos($this->loginuser->privileges, ',pvsee,') !== false) { ?>
				  <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('paymentvouchers'); ?> <i class="fa fa-file-o"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',pvsee,') !== false) { ?>
							<li><a href="<?php echo base_url(); ?>paymentvouchers"><?php echo lang('paymentvouchers'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>paymentvouchers/date/<?php echo date('Y-m-d'); ?>"><?php echo lang('paymentvoucherstoday'); ?></a></li>
						<?php } ?>
					</ul>
                  </li>
				  <?php } ?>
				  
				  <?php if(strpos($this->loginuser->privileges, ',bsee,') !== false || strpos($this->loginuser->privileges, ',pvaccadd,') !== false || strpos($this->loginuser->privileges, ',pvaccsee,') !== false || strpos($this->loginuser->privileges, ',wvadd,') !== false || strpos($this->loginuser->privileges, ',wvsee,') !== false) { ?>
				   <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('accountings'); ?> <i class="fa fa-money"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',bsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>bills"><?php echo lang('bills'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',pvaccadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>accpaymentvouchers/add"><?php echo lang('add_paymentvoucher'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',pvaccsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>accpaymentvouchers"><?php echo lang('paymentvouchers'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',wvadd,') !== false) { ?><li><a href="<?php echo base_url(); ?>withdrowvouchers/add"><?php echo lang('add_withdrowvoucher'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',wvsee,') !== false) { ?><li><a href="<?php echo base_url(); ?>withdrowvouchers"><?php echo lang('withdrowvouchers'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>

				  <?php if(strpos($this->loginuser->privileges, ',generalreport,') !== false || strpos($this->loginuser->privileges, ',staticsreport,') !== false || strpos($this->loginuser->privileges, ',incomesreport,') !== false || strpos($this->loginuser->privileges, ',outcomesreport,') !== false || strpos($this->loginuser->privileges, ',itreport,') !== false || strpos($this->loginuser->privileges, ',breport,') !== false || strpos($this->loginuser->privileges, ',oreport,') !== false) { ?>
				  <li><a><span class="fa fa-chevron-down"></span> <?php echo lang('reports'); ?> <i class="fa fa-bar-chart-o"></i></a>
					<ul class="nav child_menu">
						<?php if(strpos($this->loginuser->privileges, ',generalreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/general"><?php echo lang('general'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',staticsreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/statistics"><?php echo lang('statistics'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',incomesreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/incomes"><?php echo lang('incomes'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',outcomesreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/outcomes"><?php echo lang('outcomes'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',itreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/stores"><?php echo lang('itemtypes'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',breport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/bills"><?php echo lang('bills'); ?></a></li><?php } ?>
						<?php if(strpos($this->loginuser->privileges, ',oreport,') !== false) { ?><li><a href="<?php echo base_url(); ?>reports/orders"><?php echo lang('orders'); ?></a></li><?php } ?>
					</ul>
                  </li>
				  <?php } ?>

				  <!--<li><a><i class="fa fa-bar-chart-o"></i> <?php echo lang('reports'); ?> <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url(); ?>reports/reportsnum"><?php echo lang('reportsnum'); ?></a></li>
                      <li><a href="<?php echo base_url(); ?>reports/income"><?php echo lang('income'); ?></a></li>
					  <li><a href="<?php echo base_url(); ?>reports/mostshops"><?php echo lang('mostshops'); ?></a></li>
					  <li><a href="<?php echo base_url(); ?>reports/mostitem"><?php echo lang('mostitem'); ?></a></li>
					  <li><a href="<?php echo base_url(); ?>reports/driversrate"><?php echo lang('driversrate'); ?></a></li>
					  <li><a href="<?php echo base_url(); ?>reports/shopsrate"><?php echo lang('shopsrate'); ?></a></li>
					  <li><a href="<?php echo base_url(); ?>reports/mostusers"><?php echo lang('mostusers'); ?></a></li>
                    </ul>
                  </li>-->
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!--<div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>-->
            <!-- /menu footer buttons -->
          </div>
        </div>