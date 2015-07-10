<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
	<div class="row"> 
		<div class="col-md-10">			
			<?php echo anchor('Queues/index/#', 'Start Sending Messages', 'class="btn btn-info btn-flat status"') ?>			
		</div>			
	</div>
	<!-- End buttons -->
	<!-- Start status -->
	<div class="row"> 
		<section class="content-header">
			<span class="btn btn-primary btn-xs margin-bottom "><?php echo _('Total ques'); ?>: <span>102</span></span>
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
					<h3 class="box-title"><?php echo _('All ques'); ?></h3>
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
								<tr>
									<td>5</td>
									<td>(id: 6401) 8615889347573 <span class="label label-success">ACTIVE</span></td>
									<td>966555008077</td>
									<td>Campaign Quran</td>
									<td>Image</td>
									<td align="center"><span class="label label-success">Finished - Sent</span></td>
									<td>2015-05-25 02:32:43</td>									
								</tr>
								<tr>
									<td>5</td>
									<td>(id: 6401) 8615889347573 <span class="label label-success">ACTIVE</span></td>
									<td>966555008077</td>
									<td>Campaign Quran</td>
									<td>Image</td>
									<td align="center"><span class="label label-success">Finished - Sent</span></td>
									<td>2015-05-25 02:32:43</td>									
								</tr>
								<tr>
									<td>5</td>
									<td>(id: 6401) 8615889347573 <span class="label label-success">ACTIVE</span></td>
									<td>966555008077</td>
									<td>Campaign Quran</td>
									<td>Image</td>
									<td align="center"><span class="label label-success">Finished - Sent</span></td>
									<td>2015-05-25 02:32:43</td>									
								</tr>
								<tr>
									<td>5</td>
									<td>(id: 6401) 8615889347573 <span class="label label-success">ACTIVE</span></td>
									<td>966555008077</td>
									<td>Campaign Quran</td>
									<td>Image</td>
									<td align="center"><span class="label label-success">Finished - Sent</span></td>
									<td>2015-05-25 02:32:43</td>									
								</tr>
								<tr>
									<td>5</td>
									<td>(id: 6401) 8615889347573 <span class="label label-success">ACTIVE</span></td>
									<td>966555008077</td>
									<td>Campaign Quran</td>
									<td>Image</td>
									<td align="center"><span class="label label-success">Finished - Sent</span></td>
									<td>2015-05-25 02:32:43</td>									
								</tr>								
						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>