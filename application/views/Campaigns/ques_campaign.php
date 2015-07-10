<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
	<div class="row"> 
		<div class="col-md-10">			
			<?php echo anchor('Queues/processQueue/'.$campaign_id, 'Start Sending Messages', 'id="startqueue" class="btn btn-info btn-flat status"') ?>			
		</div>			
	</div>
	<!-- End buttons -->
	<!-- Start status -->
	<div class="row"> 
		<section class="content-header">
			<span class="btn btn-primary btn-xs margin-bottom "><?php echo _('Total ques'); ?>: <span><?php echo count($queueDetails); ?></span></span>
			<span class="btn btn-default btn-xs margin-bottom "><?php echo _('Remaining'); ?>: <span>0</span></span>
			<span class="btn btn-success btn-xs margin-bottom"><?php echo _('Sent'); ?> : <span>102</span></span>
			<span class="btn bg-navy btn-xs margin-bottom"><?php echo _('Sending'); ?> : <span>Completed</span></span>				
			<span class="btn bg-navy btn-xs margin-bottom"><?php echo _('Importing'); ?> : <span>Completed</span></span>				
		</section>
	</div>
	<!-- End status -->	
	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Ques for campaign: '.$campaignName); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('Sender'); ?></th>
									<th><?php echo _('Receiver'); ?></th>
									<th><?php echo _('Campaign name'); ?></th>
									<th><?php echo _('Type'); ?></th>
									<th><?php echo _('Status'); ?></th>
									<th><?php echo _('Sent message date'); ?></th>																	
								</tr>
							</thead>
							<tbody>
								<?php foreach ($queueDetails as $key => $value):  ?>
									<tr>
										<td><?php echo $value->id; ?></td>
										<td><!-- (id: 6401) --> <?php echo $value->sender_number; ?> <span class="label label-success">ACTIVE</span></td>
										<td><?php echo $value->recipient_number; ?></td>
										<td><?php echo $value->name; ?></td>
										<td><?php echo $value->message_type; ?></td>
										<td align="center">
											<?php 
											if($value->status == 1){ ?>
												<span class="label label-warning">Pending</span>
											<?php	
											}else if($value->status == 2){ ?>
												<span class="label label-success">Finished - Sent</span>
											<?php
											}
											?>
											
										</td>
										<td><?php echo $value->updated_at; ?></td>									
									</tr>
								<?php endforeach; ?>	
						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>
<script type="text/javascript">
$(document).ready(function (){
	$('#startqueue').on('click',function(){
		$(this).html("Process Started..");
		$(this).attr('disabled', 'disabled');
	});
});
</script>