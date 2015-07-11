<!-- Start Add Proxy Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php
				if ( isset($groupData[0]) ) {
					echo _('Edit Recipient Group');
				} else {
					echo _('Add Recipient Group');
				}
				?></h3>
			<div class="row"> 
				<?php echo showMessage(); ?>
				<?php validateErrors(); ?>
			</div>
			<div class="box box-success">			
				<?php
				$hidden = "";
				if ( isset($groupData[0]) ) {
					$hidden = array('id' => $groupData[0]->id);
				}
				?>

				<?php echo form_open($formAction, array('id' => 'form_sample_1')); ?>
				<?php echo form_hidden($hidden); ?>

				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Recipient Group Name'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('res_group_name', set_value('res_group_name', isset($groupData[0]->res_group_name) ? $groupData[0]->res_group_name : ""), 'class="form-control" tabindex=1 required="required" placeholder=Groupname'); ?>						
								</div>								
							</div>								
						</div>								
					</div>					
				</div>				
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Is Main Group?'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<?php
							//echo $groupData[0]->parent_group_id;
							if ( isset($groupData[0]->parent_group_id) && $groupData[0]->parent_group_id == 0 ) {
								$parentChecked = "'TRUE'";
								$subchecked = "";
							} else {
								$parentChecked = "";
								$subchecked = "'TRUE'";
							}

							$options1 = array('name' => 'isParent', 'checked' => $parentChecked, 'id' => 'isParent1', 'value' => '1', 'onclick' => 'checkRadio();');
							$options2 = array('name' => 'isParent', 'checked' => $subchecked, 'id' => 'isParent2', 'value' => '0', 'onclick' => 'checkRadio();');
							?>
							<?php echo form_radio($options1); ?>YES
							<?php echo form_radio($options2); ?>NO
						</div>																	
					</div>
				</div>					
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-2 col-md-3 control-label" id="mainGroupRequired"><?php echo _('Main Group'); ?> :</label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val" id="validationMsg">
									<?php
									$mainGroups = array('' => 'Select Main Group');
									foreach ( $selectMainGroup as $key => $value ) {
										$mainGroups[$value->id] = $value->res_group_name;
									}
									?>
									<?php echo form_dropdown('recipientGroups[main_group]', $mainGroups, isset($groupData[0]->parent_group_id) ? $groupData[0]->parent_group_id : "", 'class="form-control" id="mainGroups" tabindex="3" required="required"'); ?>
								</div>																		
							</div>																		
							<p class="help-block">(Leave Blank if main group is to be created)</p>	
						</div>																		
					</div>	
				</div>							
				<!-- <div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php //echo _('Sub Group');      ?> :</label>
						<div class="col-md-4">
				<?php
				//$subGroups = array('' => 'Select Sub Group');
				?>
							
				<?php //echo form_dropdown('senderGroups[sub_group]', $subGroups, '', 'class="form-control" disabled="disabled" id="sub_group" tabindex="1" ');   ?>						
						</div>																	
					</div>
				</div>	 -->

				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php
						if ( isset($groupData[0]) ) {
							echo form_submit('submit', 'Update Group', 'class="btn btn-success" tabindex=5');
						} else {
							echo form_submit('submit', 'Add Group', 'class="btn btn-success" tabindex=5');
						}
						?>					

						<?php echo anchor('/Recipients/groups', 'Cancel', 'class="btn btn-default" tabindex=6') ?>
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Add Group Form-->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		checkRadio();
		FormValidation.init();
		$('#mainGroups').on('change', function() {
			var parent_group_id = $(this).val();
			$.ajax({
				url: "<?php echo base_url(); ?>Senders/getSubgroups/" + parent_group_id,
			})
					.done(function(data) {
						$("#sub_group").html(data);
						$("#sub_group").removeAttr("disabled");
					});
		});
	});

	// Check Main Group radio button..
	function checkRadio() {
		var radioName = $('input:radio[name=isParent]:checked').val();
		if (radioName == 1) {
			$("#mainGroups").attr("required", false);
			$("#validationMsg").removeClass("error");
			$("#validationMsg span").remove();
			$("#mainGroupRequired span").remove();
		} else {
			$("#mainGroups").attr("required", true);
			$("#mainGroupRequired").append('<span class="required">*</span>');
		}
	}
</script>
