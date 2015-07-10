<!-- Start Add Recipients Form -->	
<section class="content">
    <div class="row">				
        <div class="col-md-12">
            <h3 class="text-center"><?php echo $label ?></h3>
            <div class="row box-error">
				<?php echo showMessage(); ?>
				<?php validateErrors(); ?>
            </div>
            <div class="box box-success">			
				<?php echo form_open($formAction, array('id' => 'form_sample_1')); ?>
				<?php echo form_hidden($hidden); ?>
                <div class="box-body formWidthChange">	
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Select Main Group'); ?> : <span class="required">*</span></label>
                            <div class="col-md-7">
								<?php
								$selectMainGroup = array();
								$selectMainGroup[0] = "Select Main Group";
								foreach ( $masterGroup as $key => $value ) {
									$selectMainGroup[$value->id] = $value->res_group_name;
								}
								?>
                                <div class="wrap-validation">
                                    <div class="check-val">
										<?php echo form_dropdown('main_group', $selectMainGroup, isset($selectedParent) ? $selectedParent : "", 'class="form-control" id="main_group" tabindex="1" required="required"'); ?>
                                    </div>
                                </div>
                            </div>		
                        </div>
                    </div>	
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Select Sub Group'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">	
                                <div class="wrap-validation">
                                    <div class="check-val">
										<?php
										if ( $label == 'Edit Recipient' ) {
											$selectSubGroup = array();
											$selectSubGroup[0] = "Select Main Group";
											foreach ( $subGroups as $key => $value ) {
												$selectSubGroup[$value->id] = $value->res_group_name;
											}

											echo form_dropdown('sub_group', $selectSubGroup, isset($selectedChild) ? $selectedChild : "", 'class="form-control" id="sub_group" tabindex="2" required="required"');
										} else {
											echo form_dropdown('sub_group', 'Select Sub Group', '', 'class="form-control" id="sub_group" tabindex="2" disabled="disabled" required="required"');
										}
										?>
                                    </div>
                                </div>
                            </div>		
                        </div>
                    </div>	
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Phone number'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">
                                <div class="wrap-validation">
                                    <div class="check-val">
										<?php echo form_input('phone_number', set_value('phone_number', isset($recipientsData[0]->phone) ? $recipientsData[0]->phone : ""), 'class="form-control" placeholder="Phone number" type="digits" minlength="10" maxlength="12" tabindex=3 required="required"'); ?>																																										
                                    </div>		
                                </div>
								<p class="help-block">(International number, but without + or 00. Example (Romania +40) - 40720123654)</p>
                            </div>		
                        </div>
                    </div>						
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('status'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">
								<?php
								$status = array(
									'' => 'Select Status',
									'1' => 'Active',
									'2' => 'Pending',
									'3' => 'Delete',
								);
								?>
                                <div class="wrap-validation">
                                    <div class="check-val">
										<?php echo form_dropdown('status', $status, isset($recipientsData[0]->status) ? $recipientsData[0]->status : '', 'class="form-control" tabindex=4" required="required"'); ?>								
                                    </div>		
                                </div>		
                            </div>		
                        </div>
                    </div>									
                </div>							
                <div class="box-footer">
                    <div class="col-md-offset-5 col-md-7">
						<?php echo form_submit('submit', 'Add recipient', 'class="btn btn-success" tabindex=5'); ?>						
						<?php echo anchor('/Recipients', 'Cancel', 'class="btn btn-default" tabindex=6') ?>
                    </div>
                </div>							
				<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- End Add Recipients Form-->	
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