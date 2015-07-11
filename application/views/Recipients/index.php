<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
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
					<h3 class="box-title"><?php echo _('Receivers list'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('Date'); ?></th>
									<th><?php echo _('Phone'); ?></th>
									<th style="width: 129px;"><?php echo _('Status'); ?></th>
									<th><?php echo _('Options'); ?></th>	
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $RecipientsData as $key => $value ) { ?>
									<tr>
										<td><?php echo date("F j, Y, g:i a", strtotime($value->created_at)); ?></td>									
										<td><?php echo $value->phone; ?></td>
										<td>
											<?php if ( $value->status == ACTIVE ) { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-success btn-flat">
													<i class="fa fa-thumbs-o-up"></i>Active</button>
											<?php } elseif ( $value->status == PENDING ) { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">
													<i class="fa fa-thumbs-o-down"></i> Inactive
												</button>
											<?php } elseif ( $value->status == DELETE ) { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">
													<i class="fa fa-thumbs-o-down"></i> Inactive
												</button>
											<?php } ?>

										</td>
										<td>
											<div class="btn-group btn-group">
												<a class="btn btn-info btn-flat edit" title="Edit" href="<?php echo base_url(); ?>Recipients/edit/<?php echo $value->recipient_id; ?>"><i class="fa fa-edit"></i>
												</a>
												<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete deleteLinkButton" title="Delete" id="<?php echo $value->recipient_id; ?>"><i class="fa fa-trash"></i> </a>
												<span id="anchor_<?php echo $value->recipient_id; ?>" style="display:none;">
													<a href="<?php echo base_url(); ?>Recipients/delete/<?php echo $value->recipient_id; ?>" class="btn btn-default">Delete</a></span>													
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