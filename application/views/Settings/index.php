<!-- Start Update Settings Form -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php echo _('General Settings'); ?></h3>
			<div class="box box-success">			
				<?php echo form_open('Settings/index'); ?>
				<div class="box-body inputWidth">	
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron sleep time'); ?> :
								<p class="help-block">(If you used WART password when obtaining the whatsapp password, please put it here)</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[1]', 'tabindex' => '1', 'value' => '800')); ?> 
								</span>
								<span class="secondsSpan">Seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron sleep after X'); ?> :
								<p class="help-block">After how many processes will sleep the cron cron_sleep_after</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[2]', 'tabindex' => '2', 'value' => '800')); ?>									
								</span>
								<span class="secondsSpan">processes</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron SIM testing limit'); ?> :
								<p class="help-block">How many numbers will be tested by one SIM card in a loop cron_sim_test_limit</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[3]', 'tabindex' => '3', 'value' => '100')); ?>									
								</span>
								<span class="secondsSpan">tests</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron SIM message limit'); ?> :
								<p class="help-block">How many numbers will be messaged by one SIM card in a loop cron_sim_message_limit</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[4]', 'tabindex' => '4', 'value' => '1')); ?>									
								</span>
								<span class="secondsSpan">messages</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron SIM sleep between SIMs loop'); ?> :
								<p class="help-block">Cron sleep time between loops in testing numbers cron_sleep_between_test_sim_loop</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[5]', 'tabindex' => '5', 'value' => '5')); ?>									
								</span>
								<span class="secondsSpan">seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron SIM sleep between MESSAGES SIMs loop'); ?> :
								<p class="help-block">Cron sleep time between loops in message sending cron_sleep_between_message_sim_loop</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[6]', 'tabindex' => '6', 'value' => '3600')); ?>									
								</span>
								<span class="secondsSpan">seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Cron sleep time between TEXT and PICTURE'); ?> :
								<p class="help-block">The delay between sending the picture and text cron_sleep_between_image_text</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[7]', 'tabindex' => '7', 'value' => '1')); ?>									
								</span>
								<span class="secondsSpan">seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Send picture first'); ?> :
								<p class="help-block">When sending a campaign with text and picture, choose what to send first, picture or text. cron_first_picture</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[8]', 'tabindex' => '8', 'value' => '1')); ?>									
								</span>
								<span class="secondsSpan">1 - first picture | 0 - first text </span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Start sending hour'); ?> :
								<p class="help-block">A morning hour to start the sending messages. start_sending_hour</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[13]', 'tabindex' => '9', 'value' => '0')); ?>									
								</span>
								<span class="secondsSpan">numeric integer </span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Stop sending hour'); ?> :
								<p class="help-block">An evening hour to stop the sending stop_sending_hour</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[14]', 'tabindex' => '10', 'value' => '0')); ?>									
								</span>
								<span class="secondsSpan">numeric integer </span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Pause time between messages (start)'); ?> :
								<p class="help-block">Pause time between messages (start of sleep) pause_between_msg_start</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[15]', 'tabindex' => '11', 'value' => '1')); ?>									
								</span>
								<span class="secondsSpan">seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Pause time between messages (stop)'); ?> :
								<p class="help-block">Pause time between messages (stop of sleep) pause_between_msg_stop</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[16]', 'tabindex' => '12', 'value' => '2')); ?>									
								</span>							
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('WhatsApp statuses'); ?> :
								<p class="help-block">Use this to update custom statuses for your senders. One per line. whatsapp_statuses</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php
									$messagesTextarea = array("name" => "options[18]", "class" => "form-control", "cols" => "40", "rows" => "10", "tabindex" => "13");
									echo Form_textarea($messagesTextarea);
									?>									
								</span>								
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('Auto-Respond messages'); ?> :
								<p class="help-block">Use this option to add auto respond messages to users. whatsapp_auto_responder</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php
									$textarea = array("name" => "options[17]", "class" => "form-control", "cols" => "40", "rows" => "10", "tabindex" => "14", "value" => "I am available I am using whatsapp");
									echo Form_textarea($textarea);
									?>									
								</span>
								<span class="secondsSpan">seconds</span>
							</div>		
						</div>
					</div>						
					<div class="form-group">	
						<div class="row">
							<label class="col-md-offset-2 col-md-4 control-label"><?php echo _('SIM hash password after..'); ?> :
								<p class="help-block">Refresh WhatsApp password after X messages refresh_password_after_X_messages</p>
							</label>
							<div class="col-md-4">
								<span class="floatLeftSpan">
									<?php echo form_input(array('class' => 'form-control', 'name' => 'options[19]', 'tabindex' => '15', 'value' => '25000')); ?>									
								</span>
								<span class="secondsSpan">messages</span>
							</div>		
						</div>
					</div>	
				</div>							
				<div class="box-footer">
					<div class="col-md-offset-6 col-md-6">
						<?php echo form_submit('submit', 'Save Changes', 'class="btn btn-success" tabindex=16'); ?>												
					</div>
				</div>							
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
<!-- End Update Settings Form-->	
