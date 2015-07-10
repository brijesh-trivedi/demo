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
					<h3 class="box-title"><?php echo _('Campaigns list'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('Name'); ?></th>
									<th><?php echo _('Created at'); ?></th>
									<th><?php echo _('Status'); ?></th>									
									<th><?php echo _('Actions'); ?></th>																	
								</tr>
							</thead>
							<tbody>
								<?php foreach ($campaignDetails as $key => $value):  ?>
									<tr>
										<td><?php echo $value->id; ?></td>									
										<td><?php echo $value->name; ?></td>
										<td><?php echo $value->created_at; ?></td>
										<td align="center">
											 
												<?php if($value->status == CAMPAIGN_WAITING) { ?> 
													<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">
													<i class="fa fa-fw fa-check-square-o"></i>
													WAITING TO START <?php } else if($value->status == CAMPAIGN_PENDING) { ?> 
													<button disabled="disabled" class="table-status btn btn-block btn-warning btn-flat">
													<i class="fa fa-fw fa-check-square-o"></i>
													IN PROCESS <?php } else if ($value->status == CAMPAIGN_COMPLETE) { ?> 
														<button disabled="disabled" class="table-status btn btn-block btn-success btn-flat">
														<i class="fa fa-fw fa-check-square-o"></i>
													COMPLETE 
													<?php } ?>
												
											</button>
										</td>
										<td>
											<div class="btn-group btn-group">
												<?php echo anchor('Campaigns/ques_campaign/'.$value->id, '<i class="fa fa-pencil"></i>','class="btn btn-primary btn-flat test-proxy"') ?>
												<a data-target="#edit_proxy" data-toggle="modal" class="btn btn-info btn-flat edit" title="Export report"><i class="fa fa-fw fa-file-text-o"></i></a>
												<a data-target="#delete_confirm" href="<?php echo base_url(); ?>Campaigns/delete/<?php echo $value->id;?>" class="btn btn-danger btn-flat delete" title="Delete"><i class="fa fa-trash"></i> </a>
											</div>
										</td>
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