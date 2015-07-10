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
									<th><?php echo _('Created at'); ?></th>
									<th><?php echo _('status'); ?></th>
									<th><?php echo _('Options'); ?></th>									
								</tr>
							</thead>
							<tbody>
								<?php foreach ($groupData as $key => $value) { ?>
								<tr>
									<td><?php echo $value->id; ?></td>
									<td><?php echo $value->res_group_name; ?></td>
									<td><?php echo $value->subGroupCount; ?></td>
									<td><?php echo date("F j, Y, g:i a", strtotime($value->created_at));  ?></td>
									<td>Status</td>
									
									<td>
										<div class="btn-group btn-group">
											<?php echo anchor('Recipients/sub_groups/'.$value->id, '<i class="fa fa-group"></i>', 'class="btn btn-primary btn-flat"') ?>
											<a data-proxy-password="vBL472cc" data-proxy-username="saudalq" data-proxy-port="29842" data-proxy-ip="23.105.165.7" data-proxy-id="7701" data-target="#edit_proxy" href="<?php echo base_url(); ?>Recipients/edit_recipient_group/<?php echo $value->id; ?>" class="btn btn-info btn-flat edit" title="Edit"><i class="fa fa-edit"></i></a>
											<a data-proxy-id="7701" data-target="#delete_confirm" href="<?php echo base_url(); ?>Recipients/deletegroup/<?php echo $value->id; ?>" class="btn btn-danger btn-flat delete" title="Delete"><i class="fa fa-trash"></i> </a>
										</div>
									</td>
								</tr>
								<?php }?>
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
