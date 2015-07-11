<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fileupload.css">
<!-- Start Import Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php echo _('Import Recipient'); ?></h3>
			<div class="row"> 
				<?php echo showMessage(); ?>
				<?php validateErrors(); ?>
			</div>
			<div class="box box-success">			
				<?php echo form_open_multipart('Recipients/import', array('id' => 'form_sample_1')); ?>
				<div class="box-body formWidthChange">								
					<div class="form-group">
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Recipients'); ?> :<span class="required">*</span></label>
						<div class="col-md-7">
							<div class="wrap-validation">
								<div class="check-val">
									<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Select file...</span>
										<!--The file input field used as target for the file upload widget--> 
										<?php
										$importFile = array(
											'type' => 'file',
											'tabindex' => '1',
											'name' => 'file',
											'required' => 'required'
										);
										echo form_upload($importFile);
										?>								
									</span><p class="help-block"></p>							
									<?php echo form_hidden('kpxlz', '1'); ?>
								</div>																											
							</div>																											
						</div>																											
					</div>	
					<div class="form-group">
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Skip Headers'); ?> :</label>
						<div class="col-md-7">
							<input type="checkbox" name="skipheaders" value="1">
							<p class="help-block">(Please check if you have included headers in your csv file.)</p>
						</div>	
					</div>
				</div>							
				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php echo form_submit('submit', 'Import Recipients', 'class="btn btn-success" tabindex=2'); ?>						
						<?php echo anchor('/Recipients', 'Cancel', 'class="btn btn-default" tabindex=3') ?>
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
<script>
	$('#main_group').change(function() {
		var val = $(this).val();
		if (val != 0)
		{
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Recipients/getSubGroupsValue',
				data: {
					id: val
				},
				success: function(html) {
					var sub_group = $('#sub_group');
					$("#sub_group").removeAttr("disabled");
					sub_group.empty();
					sub_group.append(html);
				}
			});
		}

	});
</script>
