var FormValidation = function() {
	var handleValidation1 = function() {
		// for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form_sample_1');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);
		form1.validate({
			//ignore: '',
			errorClass: 'error',
			validClass: 'success',
			errorElement: 'span',
			rules: {
				name: {
					minlength: 5,
					required: true
				},
				email: {
					required: true,
					email: true
				},
				textarea: {
					required: true,
					email: true
				},
				field: {
					required: true,
					phoneUS: true
				},
				url: {
					required: true,
					url: true
				},
				number: {
					required: true,
					number: true
				},
				digits: {
					minlength: 10,
					maxlength: 12,
					required: true,
					digits: true
				},
				creditcard: {
					required: true,
					creditcard: true
				},
				occupation: {
					minlength: 5
				},
				category: {
					required: true
				},
			},
			invalidHandler: function(event, validator) {
				success1.hide();
				error1.show();
				//App.scrollTo(error1, -200);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').addClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeOut();
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').removeClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeIn();
			},
			success: function(label) {
				label.closest('.validation').removeClass('has-error'); // set success class to the control group

			},
			submitHandler: function(form) {
				$('#Submit').attr('disabled', 'disabled');
				$('.showLoder').show();
				$('#opacitylow').css({'opacity': 0.5});
				$('.showLoder').css({'opacity': 2.0});
				form.submit();

			}

		});
	};
	var handleValidation2 = function() {
		// for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form_sample_2');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);
		form1.validate({
			errorClass: 'error',
			validClass: 'success',
			errorElement: 'span',
			rules: {
				name: {
					minlength: 5,
					required: true
				},
			},
			invalidHandler: function(event, validator) {
				success1.hide();
				error1.show();
				//App.scrollTo(error1, -200);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').addClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeOut();
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').removeClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeIn();
			},
			success: function(label) {
				label.closest('.validation').removeClass('has-error'); // set success class to the control group

			},
			submitHandler: function(form) {
				$('#Submit').attr('disabled', 'disabled');
				$('.showLoder').show();
				$('#opacitylow').css({'opacity': 0.5});
				$('.showLoder').css({'opacity': 2.0});
				form.submit();

			}

		});
	};

	var handleValidation3 = function() {
		// for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form_add_campaign');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);
		form1.validate({
			errorClass: 'error',
			validClass: 'success',
			errorElement: 'span',
			rules: {
				name: {
					minlength: 5,
					required: true
				},
			},
			invalidHandler: function(event, validator) {
				success1.hide();
				error1.show();
				//App.scrollTo(error1, -200);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').addClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeOut();
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('div.check-val').removeClass(errorClass);
				$(element).parents('div.check-val').next('div.' + validClass).fadeIn();
			},
			success: function(label) {
				label.closest('.validation').removeClass('has-error'); // set success class to the control group

			},
			submitHandler: function(form) {
				var checkboxFlag = false;
				$("#selectedRecipientsLists input:checkbox").each(function () {
					if($(this).val() > 0 && $(this).val() != 'undefined') {
						checkboxFlag = true;
					}
				 });
				 
				 if(!checkboxFlag) {
					 success1.hide();
					 error1.show();
					 $("#selected-recipients-lists").css('border', '1px solid red');
					return false;
				 } else {
					$('#Submit').attr('disabled', 'disabled');
					$("#selected-recipients-lists").css('border', 'none');
					$('.showLoder').show();
					$('#opacitylow').css({'opacity': 0.5});
					$('.showLoder').css({'opacity': 2.0});
				 }
				//form.submit();
			}

		});
	};
	return {
		//main function to initiate the module
		init: function() {
			handleValidation1();
			handleValidation2();
			handleValidation3();
		}
	};
}();
