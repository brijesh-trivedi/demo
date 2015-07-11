<!-- Start Add Proxy Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php
				if ( isset($groupData[0]) ) {
					echo _('Edit Sender Group');
				} else {
					echo _('Add Sender Group');
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
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Sender Group Name'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('group_name', set_value('group_name', isset($groupData[0]->group_name) ? $groupData[0]->group_name : ""), 'class="form-control" tabindex=1 required="required" placeholder=Groupname'); ?>						
								</div>								
							</div>								
						</div>								
					</div>					
				</div>				
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Is Main Group?'); ?> :</label>
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
						<label class="col-md-offset-3 col-md-2 control-label" id="mainGroupRequired"><?php echo _('Main Group'); ?> :</label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val" id="validationMsg">
									<?php
									$mainGroups = array('' => 'Select Main Group');
									foreach ( $selectMainGroup as $key => $value ) {
										$mainGroups[$value->id] = $value->group_name;
									}
									?>
									<?php echo form_dropdown('senderGroups[main_group]', $mainGroups, '', 'class="form-control" id="mainGroups" tabindex="3" required="required"'); ?>
								</div>																		
							</div>	
							<p class="help-block">(Leave Blank if main group is to be created)</p>
						</div>																		
					</div>	
				</div>							
				<!-- <div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Sub Group'); ?> :<span class="required">*</span></label>
						<div class="col-md-4">
							<div class="wrap-validation">
								<div class="check-val">
				<?php // echo form_dropdown('senderGroups[sub_group]', $mainGroups, '', 'class="form-control" id="sub_group tabindex=1" required="required"'); ?>						
								</div>																	
							</div>																	
						</div>																	
					</div>
				</div>	 -->

				<div class="box-footer">
					<div class="col-md-offset-5 col-md-7">
						<?php
						if ( isset($groupData[0]) ) {
							echo form_submit('submit', 'Update Group', 'class="btn btn-success" tabindex=4');
						} else {
							echo form_submit('submit', 'Add Group', 'class="btn btn-success" tabindex=4');
						}
						?>					

						<?php echo anchor('/Senders/groups', 'Cancel', 'class="btn btn-default" tabindex=5') ?>
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Add Proxy Form-->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		checkRadio();
		FormValidation.init();
		$('#mainGroups').on('change', function() {

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
