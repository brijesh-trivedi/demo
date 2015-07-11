<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
	<div class="row"> 
		<div class="col-md-10">			
			<?php echo anchor('Messages/index/#', 'Export messages', 'class="btn btn-info btn-flat status"') ?>			
		</div>			
		<div class="col-md-2">			
			<?php echo anchor('Messages/index/#', 'Delete all messages', 'class="btn btn-danger btn-flat status"') ?>		
		</div>			
	</div>
	<!-- End buttons -->
	<!-- Start status -->
	<div class="row"> 
		<section class="content-header">
            <?php $total = 0; foreach($messageStats as $stats): $total += $stats->cnt; ?>
                <span class="btn btn-success btn-xs margin-bottom"><?php echo ucfirst($stats->type). _(' messages'); ?> : <span><?php echo $stats->cnt ?></span></span>
            <?php endforeach; ?>
            <span class="btn btn-primary btn-xs margin-bottom "><?php echo _('Total messages'); ?>: <span><?php echo $total ?></span></span>
		</section>
	</div>
	<!-- End status -->
	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Message list'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('Date'); ?></th>
									<th><?php echo _('From'); ?></th>
									<th><?php echo _('To Sender'); ?></th>
									<th><?php echo _('Type'); ?></th>
									<th><?php echo _('Content'); ?></th>																								
								</tr>
							</thead>
							<tbody>
                                <?php foreach($messageData as $message): ?>
								<tr>
									<td><?php echo $message->received_at ?></td>
									<td><?php echo $message->from_number ?><br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td><?php echo $message->phone;?></td>
									<td><?php echo $message->type ?></td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
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