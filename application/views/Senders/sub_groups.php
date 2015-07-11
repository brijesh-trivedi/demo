<section class="content-header">
	<button data-target="#add_group" data-toggle="modal" class="btn btn-success pull-right"><i class="fa fa-plus addAction"></i> New Sub Group</button>
	<div class="clearfix"></div>
</section>
<!-- Main content -->
<section class="content">
	<div class="row"> 
            <?php echo showMessage(); ?>
            <?php validateErrors(); ?>
    </div>
	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Sub Groups List'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('Group Name'); ?></th>
									<th><?php echo _('Senders'); ?></th>
									<th><?php echo _('Created at'); ?></th>
									<th><?php echo _('Quality'); ?></th>
									<th><?php echo _('Options'); ?></th>									
								</tr>
							</thead>
							<tbody>
								<?php if(isset($subGroups) && count($subGroups)>0): ?>
									<input type="hidden" data-parent-group="" id="parent_group"> 
									<?php foreach ($subGroups as $key => $value): ?>

									<tr>
										<td><?php echo $value->id; ?></td>
										<td><?php echo $value->group_name; ?></td>
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
												<a data-group-id="<?php echo $value->id; ?>" data-group-name="<?php echo $value->group_name; ?>" data-target="#edit_group" data-toggle="modal" class="btn btn-info btn-flat edit editAction" title="Edit"><i class="fa fa-edit"></i></a>
												<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete" title="Delete"><i class="fa fa-trash"></i> </a>
											</div>
										</td>
									</tr>								
									<?php endforeach; ?>
								<?php endif; ?>
															
						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>

<!-- Add Group Modal -->
<div class="modal fade" id="add_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open('Senders/add_sub_groups', array('id' => 'form_sample_1')); ?>
			<input type="hidden" name="parent_group_id" id="parent_group_id" value="<?php echo $parent_group_id ?>">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _('Add New Sub Group'); ?><span class="required">*</span></h4>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<div class="row">
						<div class="col-md-12">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('sub_group_name', $this->input->post('sub_group_name'), 'class="form-control" tabindex=1 required="required" placeholder="Sub Group Name"'); ?>								
								</div>
							</div>
						</div>
					</div>				  
				</div>				
			</div>
			<div class="modal-footer">
				<?php echo form_button('button', 'Close', 'class="btn btn-default" data-dismiss="modal" tabindex=2') ?>
				<?php echo form_submit('submit', 'Add Sub Group', 'class="btn btn-success" tabindex=3'); ?>										
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- Delete Group Modal -->
<div class="modal fade modal-danger" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _('Confirm Delete'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<h4>Are you sure you want to delete Sub Group #<span class="group_id"></span> permanently?</h4>
					<div id="active" style="display:none">
						<button class="btn btn-success btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-check fa-2x"></i></button>
						<p class="text-success"><br/>Results: Group deleted successful!</p>
					</div>
					<div id="inactive" style="display:none">
						<button class="btn btn-danger btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-times fa-2x"></i></button>
						<p class="text-danger"><br/>Results: Failed to delete Group, Try again!</p>
					</div>
					<div id="timeout" style="display:none">
						<button class="btn btn-warning btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-warning fa-2x"></i></button>
						<p class="text-warning"><br/>Can't delete group at this moment, please try again later!</p>
					</div>
					<div id="loading" style="display:none">
						<p><i class="fa fa-fw fa-cog fa-3x fa-spin"></i></p>
						<p>Deleteing Group ...</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-default" data-group-id="" id="do_delete_group">Delete Group</button>
			</div>
		</div>
	</div>
</div>

<!-- Edit Group Modal -->
<div class="modal fade" id="edit_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'form_sample_2')); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _('Edit Sub Group'); ?><span class="required">*</span><span class="group_id"></span></h4>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<div class="row">
						
						<?php echo form_hidden('parent_group_id', $parent_group_id); ?>
						<div class="col-md-12">
							<div class="wrap-validation">
								<div class="check-val">
									<?php echo form_input('sub_group_name', $this->input->post('sub_group_name'), ' id="sub_group_name" class="form-control edit_name" tabindex=1 required="required" placeholder="Group Name"'); ?>							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo form_button('button', 'Close', 'class="btn btn-default" data-dismiss="modal" tabindex=2') ?>
				<?php echo form_submit('submit', 'Edit Sub Group', 'class="btn btn-success" tabindex=3'); ?>														
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/customFormValidation.js"></script>
<script>
	jQuery(document).ready(function() {
		FormValidation.init();
		$(".editAction").click(function(){
			$("#sub_group_name").val($(this).data("group-name"))
			$("#form_sample_2").attr('action','<?php echo base_url();?>Senders/add_sub_groups/'+$(this).data("group-id"));
			
		});
		
	});
</script>