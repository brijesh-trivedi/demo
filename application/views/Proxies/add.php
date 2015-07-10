<!-- Start Add Proxy Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php
				if ( isset($proxyData[0]) ) {
					echo _('Edit Proxy');
				} else {
					echo _('Add New Proxy');
				}
				?></h3>
			<div class="row"> 
				<?php echo showMessage(); ?>
				<?php validateErrors(); ?>
			</div>
			<div class="box box-success">			
				<?php
				$hidden = "";
				if ( isset($proxyData[0]) ) {
					$hidden = array('id' => $proxyData[0]->id);
				}
				$id = array('id' => 'form_sample_1');
				?>

				<?php echo form_open($formAction, $id); ?>
				<?php echo form_hidden($hidden); ?>

				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Proxy'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('ip', set_value('ip', isset($proxyData[0]->ip_address) ? $proxyData[0]->ip_address : ""), 'class="form-control" tabindex=1 placeholder=IP required="required"'); ?>						
								</div>								
							</div>								
							<p class="help-block">(Ex: 127.0.0.1)</p>
						</div>								
					</div>	
				</div>							
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Port'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('port', set_value('port', isset($proxyData[0]->port) ? $proxyData[0]->port : ""), 'class="form-control" tabindex=2 placeholder=Port required="required"'); ?>		
								</div>																		
							</div>																		
						</div>																		
					</div>	
				</div>							
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Username'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('username', set_value('username', isset($proxyData[0]->username) ? $proxyData[0]->username : ""), 'class="form-control" tabindex=3 placeholder=Username required="required"'); ?>							
								</div>																	
							</div>																	
						</div>																	
					</div>
				</div>							
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Password'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('password', set_value('password', isset($proxyData[0]->password) ? $proxyData[0]->password : ""), 'class="form-control" tabindex=4 placeholder=Password required="required"'); ?>							
								</div>																											
							</div>																											
						</div>																											
					</div>																				
				</div>							
				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php
						if ( isset($proxyData[0]) ) {
							echo form_submit('submit', 'Update proxy', 'class="btn btn-success" tabindex=5');
						} else {
							echo form_submit('submit', 'Add proxy', 'class="btn btn-success" tabindex=5');
						}
						?>					

						<?php echo anchor('/Proxies', 'Cancel', 'class="btn btn-default" tabindex=6') ?>
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Add Proxy Form-->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
	jQuery(document).ready(function() {
		FormValidation.init();
	});
</script>