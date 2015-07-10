<!-- Start Add Sender Form -->	
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
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Select Main Group'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">
								<?php
								$selectMainGroup = array();
								$selectMainGroup[""] = "Select Main Group";
								foreach ( $masterGroup as $key => $value ) {
									$selectMainGroup[$value->id] = $value->group_name;
								}
								?>
								<div class="wrap-validation">
                                    <div class="check-val">
										<?php echo form_dropdown('main_group', $selectMainGroup, isset($selectedParent) ? $selectedParent : "", 'class="form-control" id="main_group" tabindex="1" required="required"');
										?>
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
										if ( $label == 'Edit Sender' ) {
											$selectSubGroup = array();
											$selectSubGroup[""] = "Select Main Group";
											foreach ( $subGroups as $key => $value ) {
												$selectSubGroup[$value->id] = $value->group_name;
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
										<?php echo form_input('phone_number', set_value('phone_number', isset($senderData[0]->phone) ? $senderData[0]->phone : ""), 'class="form-control" id="phone_number" placeholder="Phone number" type="digits" minlength="10" maxlength="12" tabindex=3 required="required"'); ?>
                                    </div>
                                </div>
								<p class="help-block">(International number, but without + or 00. Example (Romania +40) - 40720123654)</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Nickname'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">
                                <div class="wrap-validation">
                                    <div class="check-val">
                                        <?php echo form_input('nickname', set_value('nickname', isset($senderData[0]->nickname) ? $senderData[0]->nickname : ""), 'class="form-control" id="nickname tabindex=7" placeholder="Nickname" tabindex=4 required="required"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Password'); ?> :<span class="required">*</span></label>
                            <div class="col-md-7">
                                <div class="wrap-validation">
                                    <div class="check-val">
                                        <?php echo form_input('password', set_value('password', isset($senderData[0]->password) ? $senderData[0]->password : ""), 'class="form-control" id="password" placeholder="Password" tabindex=5 required="required"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Identity number'); ?> :</label>
                            <div class="col-md-7">
                                <div class="wrap-validation">
                                    <div class="check-val">
                                        <?php echo form_input('identity_number', set_value('identity_number', isset($senderData[0]->identity_number) ? $senderData[0]->identity_number : ""), 'class="form-control" id="identity_number" placeholder="Identity number" tabindex=6'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
						<div class="form-group">									
                            <div class="row">
                                <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('WART Password'); ?> :</label>
                                <div class="col-md-7">
                                    <div class="wrap-validation">
                                        <div class="check-val">
											<?php echo form_input('wart_password', set_value('wart_password', isset($senderData[0]->wart_password) ? $senderData[0]->wart_password : ""), 'class="form-control" id="wart_password tabindex=5" placeholder="WART Password" tabindex=7 '); ?>
                                        </div>									
                                    </div>	
									<p class="help-block">(If you used WART password when obtaining the whatsapp password, please put it here)</p>
                                </div>									
                            </div>																											
                        </div>	                        
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-offset-2 col-md-3 control-label"><?php echo _('Proxy'); ?> :</label>
                                <div class="col-md-7">	
									<?php
									$selectedProxies = array();
									foreach ( $proxies as $key => $value ) {
										$selectedProxies[$value->id] = $value->ip_address . ":" . $value->port;
									}
									?>
                                    <div class="wrap-validation">
										<div class="check-val">
											<?php echo form_dropdown('proxy', $selectedProxies, isset($senderData[0]->proxy_id) ? $senderData[0]->proxy_id : "", 'class="form-control" id="proxy tabindex=8"'); ?>
                                        </div>
                                    </div>    
									<p class="help-block">(This proxy has to lowest usage and is ACTIVE)</p>
                                </div>								
                            </div>																											
                        </div>	                        
                    </div>
                    <div class="box-footer">
                        <div class="col-md-offset-5 col-md-7">
							<?php echo form_submit('submit', $label, 'class="btn btn-success" tabindex=9'); ?>
							<?php echo anchor('/Senders', 'Cancel', 'class="btn btn-default" tabindex=10') ?>
                        </div>
                    </div>							
					<?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Add Sender Form-->	
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
				url: '<?php echo base_url(); ?>Senders/getSubGroupsValue',
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
