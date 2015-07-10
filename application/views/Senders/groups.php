<div class="row"> 
	<?php echo showMessage(); ?>
</div>
<!-- Main content -->
<section class="content">
	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Groups List'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('Group Name'); ?></th>
									<th><?php echo _('Sub Groups'); ?></th>
									<th><?php echo _('Senders'); ?></th>
									<th><?php echo _('Created at'); ?></th>
									<th><?php echo _('Quality'); ?></th>
									<th><?php echo _('Options'); ?></th>									
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach ($groupData as $key => $value) {
								?>
								<tr>
									<td><?php echo $value->id; ?></td>
									<td><?php echo $value->group_name; ?></td>
									<td><?php echo $value->subGroupCount; ?></td>
									<td>5/10</td>
									<td><?php echo date("F j, Y, g:i a", strtotime($value->created_at));  ?></td>
									<td>
										<div class="progress  progress-bar-red">
											<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
												<span>80%</span>
											</div>
										</div>
									</td>
									<td>
										<div class="btn-group btn-group">
											<?php 
												
													echo anchor('Senders/sub_groups/'.$value->id, '<i class="fa fa-group"></i>', 'class="btn btn-primary btn-flat"'); 
											?>
											<a data-target="#edit_proxy" class="btn btn-info btn-flat edit" title="Edit" href="<?php echo base_url(); ?>Senders/edit_sender_group/<?php echo $value->id; ?>"><i class="fa fa-edit"></i></a>
											<a data-target="#delete_confirm"  href="<?php echo base_url(); ?>Senders/deletegroup/<?php echo $value->id; ?>" class="btn btn-danger btn-flat delete" title="Delete"><i class="fa fa-trash"></i> </a>
										</div>
									</td>
								</tr>
								<?php
								}
								?>
								
						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>