<!-- Start Add proxy to blacklist Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php echo _('Add proxy to blacklist'); ?></h3>
			<div class="box box-success">			
				<?php echo form_open('Proxies/blacklist_add_form', array('id' => 'form_sample_2')); ?>
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Proxy IP'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_hidden('kpxlz', '1'); ?>
									<?php echo form_input('blacklist_proxy[proxy_ip]', $this->input->post('blacklist_proxy[proxy_ip]'), 'class="form-control" tabindex=1 required="required"'); ?>																																										
									<p class="help-block">(example: 255.255.255.0)</p>
								</div>																											
							</div>																											
						</div>																											
					</div>																				
				</div>							
				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php echo form_submit('submit', 'Add to blacklist', 'class="btn btn-success" tabindex=2'); ?>						
						<?php echo anchor('/Proxies/blacklist', 'Cancel', 'class="btn btn-default" tabindex=3') ?>
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Add proxy to blacklist Form-->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
	jQuery(document).ready(function() {
		FormValidation.init();
	});
</script>

