<style type="text/css">
	.custom-dialog{
		width: 1200px !important;
	}
</style>
<div id="validateErrors" class="ci_error_msg" style="display:none"> 

</div>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success">
				<?php echo form_open('', array('id' => 'form_add_campaign')); ?>
				<input type="hidden" name="message_type" id="message_type" value="text">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo _('Recipients Lists'); ?></h3>
				</div><!-- /.box-header -->
				<div class="box-body">

					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<div class="col-sm-3">
									<label class="pull-right control-label"><?php echo _('Campgin Name'); ?> : <span class="required">*</span></label>
								</div>
								<div class="col-sm-9">
									<div class="wrap-validation">
										<div class="check-val">
											<input type="text" value="" name="name" id="name" class="form-control" required="required" placeholder="Campaign Name">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">														
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="active"><a aria-expanded="true" href="#tab_1" data-toggle="tab" data-message-type="text" class="tab_data">Text</a></li>
										<li class=""><a aria-expanded="false" href="#tab_2" data-toggle="tab" data-message-type="image" class="tab_data">Image</a></li>
										<li class=""><a aria-expanded="false" href="#tab_3" data-toggle="tab" data-message-type="video" class="tab_data">Video</a></li>
										<li class=""><a aria-expanded="false" href="#tab_4" data-toggle="tab" data-message-type="audio" class="tab_data">Audio</a></li>
										<li class=""><a aria-expanded="false" href="#tab_5" data-toggle="tab" data-message-type="contact" class="tab_data">Contact</a></li>
										<li class=""><a aria-expanded="false" href="#tab_6" data-toggle="tab" data-message-type="location" class="tab_data">Location</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_1">
											<label>Message</label>
											<textarea name="text_message" class="form-control" rows="10" placeholder="Text Message"></textarea>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_2">
											<label>Image</label>											
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-edit"></i></span>
												<input type="text" value="" name="image" id="image" class="form-control" placeholder="Image" data-target="#elfinder_dialog" data-toggle="modal">
											</div>

										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_3">
											<label>Video</label>											
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-edit"></i></span>
												<input type="text" value="" name="video" id="video"  class="form-control" placeholder="Video" data-target="#elfinder_dialog" data-toggle="modal">
											</div>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_4">
											<label>Audio</label>											
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-edit"></i></span>
												<input type="text" value="" name="audio" id="audio" class="form-control" placeholder="Audio" data-target="#elfinder_dialog" data-toggle="modal">
											</div>
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_5">
											<label>Contact name</label>
											<input type="text" value="" name="contact[contact_name]" class="form-control" placeholder="Contact Fullname">
											<label>Contact number</label>
											<input type="text" value="" name="contact[contact_number]" class="form-control" placeholder="Contact Number">
										</div><!-- /.tab-pane -->
										<div class="tab-pane" id="tab_6">
											<label>Location</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-globe"></i></span>
												<input type="text" value="" name="locationname" placeholder="Name of Location..." id="locationname" class="form-control">
											</div>
										</div><!-- /.tab-pane -->
									</div><!-- /.tab-content -->
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-md-3 control-label"><?php echo _('Add Numbers From'); ?> : <span class="required">*</span></label>
							<div class="col-md-3">
								<div class="item-input">
									<div class="wrap-validation">
										<div class="check-val">
											<?php
											$selectNumberGroup = array(
												'recipient_group' => 'Recipients Group',
												'manually_enter' => 'Manually Enter',
											);
											?>
											<?php echo form_dropdown('select_number_group', $selectNumberGroup, isset($selectedParent) ? $selectedParent : "", 'class="form-control" id="select_numbers_group" tabindex="2" required="required" onChange="selectNumbersFrom();"'); ?>
										</div>
									</div>
								</div>
							</div>													
						</div>
					</div>
					<div class="col-md-offset-3 col-md-9">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title" id="recipient_box_heading"></h3>
								<div class="box-tools pull-right">
									<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
								</div> 
							</div> 
							<div class="box-body">
								<div id="main_recipient_lists">
									<div class="form-group">
										<div class="row">
											<label class="col-md-2 control-label mainGroupRequired"><?php echo _('Main Group'); ?> : </label>
											<div class="col-md-3">
												<div class="item-input">
													<div class="wrap-validation">
														<div class="check-val validationMsg">
															<?php
															$selectMainGroup = array('' => 'Select Main Group',);
															foreach ( $recipientsMainGrps as $key => $value ) {
																$selectMainGroup[$value->id] = $value->res_group_name;
															}
															?>
															<?php echo form_dropdown('main_group', $selectMainGroup, isset($selectedParent) ? $selectedParent : "", 'class="form-control" id="main_group" tabindex="1" required="required"'); ?>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-md-3 control-label mainGroupRequired"><?php echo _('Main Sub Group'); ?> :</label>
												<div class="col-md-3">
													<div class="wrap-validation">
														<div class="check-val validationMsg">
															<?php
															$selectSubGroup = array(
																'' => 'Select Main Sub Group',
															);
															?>
															<?php echo form_dropdown('sub_group', $selectSubGroup, isset($selectedChild) ? $selectedChild : "", 'class="form-control" id="sub_group" disabled="disabled" tabindex="2" required="required"'); ?>
														</div>
													</div>
												</div>
											</div>							
										</div>
									</div>
									<div class="form-group">
										<label class="control-label"><?php echo _('Recipients Lists '); ?> : </label>
										<div class="row">
											<div class="col-md-8">
												<div class="item-input">
													<div class="wrap-validation">
														<div class="check-val">
															<div class="box">
																<div class="box-body no-padding">
																	<section class="connectedSortable">
																		<div class="box-body chat" id="recipients-lists">
																			<table class="table table-condensed responsive" id="allRecipientsLists">
																				<thead>
																					<tr>
																						<th style="width: 10px">Use</th>
																						<th>Phone number</th>	
																					</tr>
																				</thead>
																				<tbody></tbody>
																			</table>
																		</div> 
																	</section> 
																</div>
															</div>
															<?php echo form_button('button', '<i class="fa fa-fw fa-remove"></i> Uncheck all', 'class="btn btn-default" id="uncheckalllist"') ?>
															<?php echo form_button('button', '<i class="fa fa-fw fa-check"></i> Check all', 'class="btn btn-default" id="checkalllist"') ?>								
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">												
													<div class="add-remove-btn"> 
														<button name="add" type="button" id="add" class="btn btn-success" tabindex="5">Add</button>											
													</div>
												</div>
											</div>							
										</div>
									</div>
								</div>
								<div id="manually_add">
									<div class="form-group">	
										<label class="control-label"><?php echo _('Add Recipients Lists'); ?> :<span class="required">*</span></label>
										<div class="row">
											<div class="col-md-5">
												<div class="wrap-validation">
													<div class="check-val">										
														<?php
														$phoneTextarea = array("name" => "phone_number", "class" => "form-control", "cols" => "40", "rows" => "10", "id" => "phoneNo", "required" => "required", 'onKeyUp' => "validate(event)");
														echo Form_textarea($phoneTextarea);
														?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<?php echo form_button('button', 'Add to the recipients list', 'class="btn btn-default" onclick="addPhoneNo();"') ?>								
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo _('Main Recipient Lists '); ?> : <span class="required">*</span></label>
									<div class="row">
										<div class="col-md-8">
											<div class="item-input">
												<div class="wrap-validation">
													<div class="check-val">
														<div class="box">
															<div class="box-body no-padding">
																<section class="connectedSortable">
																	<div class="box-body chat" id="selected-recipients-lists">
																		<table class="table table-condensed responsive" id="selectedRecipientsLists">
																			<thead>
																				<tr>
																					<th style="width: 10px">Use</th>
																					<th>Phone number</th>			
																				</tr>	
																			</thead>
																			<tbody id="addNewPhoneNo"></tbody>
																		</table>
																	</div> 
																</section> 
															</div> 
														</div>	
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">												
												<div class="add-remove-btn"> 
													<button name="remove" type="button" id="remove" class="btn btn-danger" tabindex="5">Remove </button>
												</div>
											</div>
										</div>							
									</div>
								</div>
							</div> 
						</div> 
					</div>					
				</div> 
				<div class="box-footer">
					<div class="col-md-offset-3 col-md-9">
						<?php echo form_submit('submit', 'Add Campaign', 'id="addcampaign" class="btn btn-success" tabindex=5'); ?>						
						<?php echo anchor('/Campaigns', 'Cancel', 'class="btn btn-default" tabindex=6') ?>
					</div>
				</div>	
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
	jQuery(document).ready(function() {
		$("#validateErrors").hide();
		FormValidation.init();
		selectNumbersFrom();
		var checkboxArr = new Array();
		$("#addcampaign").click(function() {
			$("#selectedRecipientsLists input:checkbox").each(function () {
				if($(this).val() > 0 && $(this).val() != 'undefined') {
					checkboxArr.push($(this).val());
				}
			 });
			if ($("#form_add_campaign").valid() == true) {
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>Campaigns/add',
					data: $("#form_add_campaign").serialize()+
					"&main_recipients="+checkboxArr,
					success: function(response) {
						var resObj = $.parseJSON(response);
						if (resObj.status == "success") {
							window.location.assign("<?php echo base_url(); ?>/Campaigns/index");
						} else if (resObj.status == "error") {
							$("#validateErrors").html(resObj.result).show();
							$('.showLoder').hide();
							document.body.scrollTop = document.documentElement.scrollTop = 0;
						}
					}
				});
			}
		});
	});
	$("#image, #audio, #video").click(function() {

		var elf = $('#elfinder').elfinder({
			lang: 'en',
			url: '<?php echo base_url(); ?>Campaigns/elfinder_init', // connector URL (REQUIRED)
			getFileCallback: function(file) {
				var filePath = file; //file contains the relative url.
				//alert(ele1);
				var currentElement = $("#message_type").val();
				$('#' + currentElement).val(filePath) //add the media file path to a input value
				$('#elfinder_dialog').modal('hide');
			}
		}).elfinder('instance');

	});
	// Recipients-lists checkbox ..
	$('#uncheckalllist').click(function(e) {
		$('#allRecipientsLists input:checkbox').each(function() {
			$(this).attr('checked', false);
		});
	});
	$('#checkalllist').click(function(e) {
		$('#allRecipientsLists input:checkbox').each(function() {
			$(this).not(':disabled').prop('checked', true);
		});
	});


	var selectedRecipientsListsArr = new Array();
	var recipientsGroupPhoneArr = new Array();
	for (var i = 0; i < 10; i++) {
		recipientsGroupPhoneArr.push('998877665' + i);
	}
	// Add or Remove selected recipients list..
	$('#add').click(function() {
		var checkedCheckbox = 0;
		$('#allRecipientsLists > tbody').find('tr').each(function() {
			var row1 = $(this);
			if (row1.find('input[type="checkbox"]').is(':checked') && row1.find('input[type="checkbox"]').val()) {
				if ($.inArray(row1.find('input[type="checkbox"]').val(), selectedRecipientsListsArr) < 0) {
					selectedRecipientsListsArr.push(row1.find('input[type="checkbox"]').val());
				}
				checkedCheckbox++;
			}
		});

		var tr = '';
		$(selectedRecipientsListsArr).each(function(key, val) {
			tr = tr + '<tr id="main_recipients_id_' + key + '">' +
					'<td id="checkbox_1"><input type="checkbox" id="main_recipients_checkbox_id_' + key + '" name="main_recipients[]" class="checkboxGroup" value="' + val + '"></td>' +
					'<td>' + val + '</td>' +
					'</tr>';
		});
		$('#selectedRecipientsLists > tbody').html(tr);
		if (checkedCheckbox > 0) {
			$('#allRecipientsLists > tbody').html('');
		}
	});

	$('#remove').click(function() {
		$('#selectedRecipientsLists > tbody').find('tr').each(function() {
			var row1 = $(this);
			if (row1.find('input[type="checkbox"]').is(':checked')) {
				var mainRecipientPhone = row1.find('input[type="checkbox"]').val();
				$(this).remove();
				// Remove value from array
				selectedRecipientsListsArr.splice($.inArray(mainRecipientPhone, selectedRecipientsListsArr), 1);
			}
		});
	});

	//Hardcoded dropdownlist create..
	$('#main_group, #sub_group').change(function() {
		$("#sub_group").removeAttr("disabled");
		if ($(this).val() != "" && $(this).attr('id') == 'sub_group') {
			var subGroupId = $(this).attr('id');
			var tr = '';

			if ($('#' + subGroupId).val() != '') {
				var subGroupIdval = $('#' + subGroupId).val();

				if (subGroupIdval != 0) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>Campaigns/getRecipientPhoneNumbers',
						data: {
							id: subGroupIdval
						},
						success: function(html) {
							var recipientsGroupPhoneArr = $.parseJSON(html)
							$.each(recipientsGroupPhoneArr, function(key, val) {
								tr = tr + '<tr id="recipient_id_' + key + '">' +
										'<td id="checkbox_1"><input type="checkbox" class="checkboxGroup" value="' + val + '"></td>' +
										'<td>' + val + '</td>' +
										'</tr>';

							});
							$('#allRecipientsLists > tbody').html(tr);
						}
					});
				}

			}

			//$('#allRecipientsLists > tbody').html(tr);
		} else {
			//$('#allRecipientsLists > tbody').html("");
			var val = $(this).val();
			if (val != 0) {
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>Campaigns/getSubgroups',
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
			} else {
				$("#sub_group").attr("disabled", "disabled");
			}

		}
	});

	// Validation of phonenumber textarea..
	function validate(e) {
		console.log(e)
		var invalidcharacters = /[^0-9\n]/gi
		var phn = document.getElementById('phoneNo');
		if (invalidcharacters.test(phn.value)) {
			//e.value = e.value.replace(invalidcharacters, "");
			console.log("REPLACING");
			newstring = phn.value.replace(invalidcharacters, "");
			phn.value = newstring
		}
	}

	// Change message Type on Tab Click
	$(".tab_data").click(function() {
		var message_type = $(this).data("message-type");
		$("#message_type").val(message_type);
	});


// Hide/Show box..
	function selectNumbersFrom() {
		var selectFrom = $('#select_numbers_group option:selected').val();
		if (selectFrom == "recipient_group") {
			$("#recipient_box_heading").html("Recipients Group");
			$("#main_recipient_lists").show();
			$("#manually_add").hide();

			$("#main_group").attr("required", true);
			$("#sub_group").attr("required", true);
			$(".mainGroupRequired").append('<span class="required">*</span>');
		}
		if (selectFrom == "manually_enter") {
			$("#recipient_box_heading").html("Manually Enter");
			$("#manually_add").show();
			$("#main_recipient_lists").hide();

			$("#main_group").attr("required", false);
			$("#sub_group").attr("required", false);
			$(".validationMsg").removeClass("error");
			$(".validationMsg span").remove();
			$(".mainGroupRequired span").remove();
		}
	}

	// Add PhoneNo to dropdown..
	function addPhoneNo() {
		var phoneNo = $("#phoneNo").val();
		if (phoneNo != "" && parseInt(phoneNo)) {
			var phoneNoSplit = phoneNo.split('\n');
			$.each(phoneNoSplit, function(key, val) {
				if ($.inArray(val, selectedRecipientsListsArr) < 0) {
					selectedRecipientsListsArr.push(val);
				}
			});
			var tr = '';
			$(selectedRecipientsListsArr).each(function(key, val) {
				tr = tr + '<tr id="main_recipients_id_' + key + '">' +
						'<td id="checkbox_1"><input type="checkbox" id="main_recipients_checkbox_id_' + key + '" class="checkboxGroup" value="' + val + '"></td>' +
						'<td>' + val + '</td>' +
						'</tr>';
			});
			$('#selectedRecipientsLists > tbody').html(tr);

			$('#allRecipientsLists > tbody').html('');

			$("#phoneNo").val("");
			$("#phoneNo").attr("required", false);
		}
	}
</script>
<!-- Edit Group Modal -->
<div class="modal fade" id="elfinder_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog custom-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _('Select File'); ?><span class="required">*</span><span class="group_id"></span></h4>
			</div>
			<div class="modal-body">
				<div id="elfinder"></div>
			</div>
			<div class="modal-footer">
				<?php echo form_button('button', 'Close', 'class="btn btn-default" data-dismiss="modal" tabindex=2') ?>
				<?php //echo form_submit('submit', 'Select', 'class="btn btn-success" tabindex=3'); ?>														
			</div>

		</div>
	</div>
</div>
