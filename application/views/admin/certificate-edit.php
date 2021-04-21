		<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_certificate'); ?></h3>
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
						echo form_open_multipart('hr/updatecertificate/'.$certificate->cfid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

                      <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('user').' <span class="required">*</span>','user',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						<?php
							foreach($users as $user)
							{
								$ourtypes[$user->uid] = $user->uname;
							}											
							echo form_dropdown('user', $ourtypes, array('user'=>$certificate->cfeid), 'class="form-control" required="required"');
						?>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('title').' <span class="required">*</span>','title',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'text',
								'name' => 'title',
								'id' => 'title',
								'placeholder' => lang('title'),
								'class' => 'form-control col-md-7 col-xs-12',
								//'max' => 255,
								//'required' => 'required',
								'value' => $certificate->cftitle
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
							echo form_label(' ','',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <div class="embed-responsive embed-responsive-16by9">
						  <?php
							if(isset($certificate->cflink) && $certificate->cflink != '')
							{ 
								//$ext = pathinfo($certificate->cflink, PATHINFO_EXTENSION); if(strtoupper($ext) == 'PDF') $icon = 'fa fa-file-pdf-o'; elseif(strtoupper($ext) == 'DOC' || strtoupper($ext) == 'DOCX') $icon = 'fa fa-file-word-o'; else $icon = 'fa fa-file-image-o'; echo '<a href="../../'.$certificate->cflink.'" target="_blank"><i class="'.$icon.' fa-2x"></i></a>';
								$ext = pathinfo($certificate->cflink, PATHINFO_EXTENSION);
								if(strtoupper($ext) == 'PDF') echo '<iframe src="../../'.$certificate->cflink.'" class="embed-responsive-item" frameborder="0"></iframe>';
								elseif(strtoupper($ext) == 'DOC' || strtoupper($ext) == 'DOCX') echo '<iframe src="http://docs.google.com/gview?url=http://pixel4it.net/fanarab/'.$certificate->cflink.'&embedded=true" class="embed-responsive-item" frameborder="0"></iframe>';
								else echo '<img class="img-responsive" src="../../'.$certificate->cflink.'" />';
								$data = array(
									'oldfile'  => $certificate->cflink
								);
								echo form_hidden($data);
							}
						 ?>
						 </div>
                        </div>
                      </div>
					  <div class="form-group">
						<?php
							$data = array(
								'class' => 'control-label col-md-3 col-md-push-6 col-sm-3 col-sm-push-6 col-xs-12'
							);
							echo form_label(lang('file').' <span class="required">*</span>','file',$data);
						?>
                        <div class="col-md-6 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
						  <?php
							$data = array(
								'type' => 'file',
								'name' => 'file',
								'id' => 'file',
								'class' => 'form-control col-md-7 col-xs-12',
							);
							echo form_upload($data);
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