<!-- Delete Modal -->
<div class="modal fade modal-danger" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _('Confirm Delete'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<h4>Are you sure want to<span class="group_id"></span> delete?</h4>
					<div id="active" style="display:none">
						<button class="btn btn-success btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-check fa-2x"></i></button>
						<p class="text-success"><br/>Results: Deleted successful!</p>
					</div>
					<div id="inactive" style="display:none">
						<button class="btn btn-danger btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-times fa-2x"></i></button>
						<p class="text-danger"><br/>Results: Failed to delete, Try again!</p>
					</div>
					<div id="timeout" style="display:none">
						<button class="btn btn-warning btn-circle btn-lg" type="button" disabled="disabled" style="border-radius:30px; width:60px; height:60px"><i class="fa fa-warning fa-2x"></i></button>
						<p class="text-warning"><br/>Can't delete at this moment, please try again later!</p>
					</div>
					<div id="loading" style="display:none">
						<p><i class="fa fa-fw fa-cog fa-3x fa-spin"></i></p>
						<p>Deleting ...</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<span id="delete_anchor_tag_content"></span>				
			</div>
		</div>
	</div>
</div>