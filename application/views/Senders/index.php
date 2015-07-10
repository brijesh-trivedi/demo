<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
            <div class="row"> 
		<div class="col-md-10 ">			
			<?php echo anchor('Cron/sender_block_checker', 'Test senders', 'id="test_all" class="btn btn-primary btn-flat status"') ?>
		</div>	
	</div><br>
	<!-- End buttons -->
	<!-- Start status -->
            <div class="row"> 
            </div>
	<!-- End status -->
	<div class="row"> 
		<?php echo showMessage(); ?>
		<?php validateErrors(); ?>
	</div>

	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Senders list'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('Phone number'); ?></th>
									<th><?php echo _('Wart Password'); ?></th>
									<th><?php echo _('Nickname'); ?></th>									
									<th><?php echo _('Status'); ?></th>									
									<th><?php echo _('Created at'); ?></th>									
									<th><?php echo _('Options'); ?></th>																	
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $senderData as $key => $value ) { ?>
									<tr>
										<td><?php echo $value->id; ?></td>									
										<td><?php echo $value->phone; ?></td>
										<td><?php echo $value->wart_password; ?></td>
										<td><?php echo $value->nickname; ?></td>
										<td align="center">
											<?php if ( $value->status == ACTIVE ) { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-success btn-flat">
													<i class="fa fa-thumbs-o-up"></i> Active
												</button>
											<?php } else { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">
													<i class="fa fa-thumbs-o-down"></i> Inactive
												</button>
											<?php } ?>
										</td>

										<td><?php echo date("F j, Y, g:i a", strtotime($value->created_at)); ?></td>									
										<td>
											<div class="btn-group btn-group">
												<a class="btn btn-info btn-flat edit" title="Edit" href="<?php echo base_url(); ?>Senders/edit/<?php echo $value->id; ?>"><i class="fa fa-edit"></i>
												</a>
												<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete deleteLinkButton" title="Delete" id="<?php echo $value->id; ?>"><i class="fa fa-trash"></i> </a>
												<span id="anchor_<?php echo $value->id; ?>" style="display:none;">
													<a href="<?php echo base_url(); ?>Senders/delete/<?php echo $value->id; ?>" class="btn btn-default">Delete</a></span>													
											</div>
										</td>
									</tr>
								<?php } ?>

						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>

<!-- Delete Modal -->
<?php echo $this->load->view('pages/delete_popup', null, true); ?>
<!-- Delete Modal -->