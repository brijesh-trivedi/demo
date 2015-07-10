<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fileupload.css">
<!-- Start Import Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php echo _('Import Proxy'); ?></h3>
			<div class="row"> 
				<?php echo showMessage(); ?>
				<?php validateErrors(); ?>
			</div>
			<div class="box box-success">			
				<?php echo form_open_multipart('Proxies/import', array('id' => 'form_sample_1')); ?>
				<div class="box-body formWidthChange">								
					<div class="form-group">
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Proxies'); ?> :<span class="required">*</span></label>
						<div class="col-md-7">
							<div class="wrap-validation">
								<div class="check-val">
									<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Select file...</span>
										<!--The file input field used as target for the file upload widget--> 
										<?php
										$file = array(
											'type' => 'file',
											'tabindex' => '1',
											'name' => 'file',
											'required' => 'required'
										);
										echo form_upload($file);
										?>																	
									</span>							
									<p class="help-block">(127.0.0.1, 8080, username, password - ONE PROXY PER ROW)</p>
									<?php echo form_hidden('kpxlz', '1'); ?>
								</div>
							</div>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Skip Headers'); ?> :</label>
						<div class="col-md-7">
							<div class="wrap-validation">
								<div class="check-val">
									<input type="checkbox" name="skipheaders" value="1">
								</div>	
							</div>	
							<p class="help-block">(Please check if you have included headers in your csv file.)</p>
						</div>	
					</div>																				
				</div>							
				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php echo form_submit('submit', 'Import Proxies', 'class="btn btn-success" tabindex=2'); ?>						
						<?php echo anchor('/Proxies', 'Cancel', 'class="btn btn-default" tabindex=3') ?>
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Import Form -->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
	jQuery(document).ready(function() {
		FormValidation.init();
	});
</script>