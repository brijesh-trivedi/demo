<!-- Start NickName Form -->	
<section class="content">
    <div class="row">				
        <div class="col-md-12">
            <h3 class="text-center"><?php echo _('Update nickname'); ?></h3>
            <div class="box box-success">			
                <?php echo form_open('Senders/nickname', array('id' => 'form_sample_1')); ?>
                <div class="box-body">	
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Select Main Group'); ?> :<span class="required">*</span></label>
                            <div class="col-md-4">
                                     <?php
                                    $selectMainGroup = array();
                                     $selectMainGroup[''] = "Select Main Group";
                                    foreach ($masterGroup as $key => $value) {
                                        $selectMainGroup[$value->id] = $value->group_name;
                                    }
                                    ?>
                               <div class="wrap-validation">
                                    <div class="check-val">
                                        <?php echo form_dropdown('main_group', $selectMainGroup,isset($selectedParent) ? $selectedParent : "", 'class="form-control" id="main_group" tabindex="1" required="required"');
                                        ?>
                                    </div>		
                                </div>		
                            </div>		
                        </div>
                    </div>	
                    <div class="form-group">	
                        <div class="row">
                            <label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Select Sub Group'); ?> :<span class="required">*</span></label>
                            <div class="col-md-4">
                                <div class="wrap-validation">
                                    <div class="check-val">
                                        <?php
                                            echo form_dropdown('sub_group', 'Select Sub Group', '', 'class="form-control" id="sub_group" tabindex="2" disabled="disabled" required="required"'); 
                                        ?>
                                    </div>		
                                </div>		
                            </div>		
                        </div>
                    </div>	
                    <div class="form-group">									
                        <label class="col-md-offset-3 col-md-2 control-label"><?php echo _('Update nickname'); ?> :<span class="required">*</span></label>
                        <div class="col-md-4">
                            <div class="wrap-validation">
                                <div class="check-val">
                                    <?php echo form_hidden('kpxlz', '1'); ?>
                                    <?php echo form_input(array('name'=>'nickname','id'=>'nickname','class' => 'form-control', 'tabindex' => '1', 'value' => 'Saudi News', 'required' => 'required')); ?>																																																																																																																												
                                    <?php echo form_hidden('kpnickname', '1'); ?>							
                                </div>																											
                            </div>																											
                        </div>																											
                    </div>
                    <div class="col-md-offset-5 col-md-7">
                        <p class="help-block">(NOTE: This nickname will be updated to all senders in selected sub group)</p>
                    </div>
                </div>							
                <div class="box-footer">
                    <div class="col-md-offset-5 col-md-7">
                        <?php echo form_submit('submit', 'Change nickname', 'class="btn btn-success" tabindex=2'); ?>						
                        <?php echo anchor('/Senders', 'Cancel', 'class="btn btn-default" tabindex=3') ?>
                    </div>
                </div>							
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<!-- End NickName Form-->	
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
    jQuery(document).ready(function () {
        FormValidation.init();
    });
</script>
<script>
    $('#main_group').change(function () {
        var val = $(this).val();
        if (val != 0)
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>Senders/getSubGroupsValue',
                data: {
                    id: val
                },
                success: function (html) {
                    var sub_group = $('#sub_group');
                    $("#sub_group").removeAttr("disabled");
                    sub_group.empty();
                    sub_group.append(html);
                }
            });
        }

    });
</script>