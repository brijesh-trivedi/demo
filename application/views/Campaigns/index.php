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
												<?php //echo anchor('Queues/processQueue/'.$value->id, '<i class="fa fa-play-circle-o"></i>','class="btn btn-primary btn-flat test-proxy"') ?>
												<?php if ($value->status == CAMPAIGN_WAITING) { ?> 

												<a data-target="#run_confirm" data-toggle="modal" class="btn btn-success btn-flat edit runcampaign" title="Run Campaign" id="<?php echo $value->id; ?>"><i class="fa fa-play-circle-o"></i> </a>
												<span id="anchor_c_<?php echo $value->id; ?>" style="display:none;">
													<a href="<?php echo base_url(); ?>Queues/processQueue/<?php echo $value->id; ?>" class="btn btn-default">Run Campaign</a></span>												
												<?php } ?>

												<?php echo anchor('Campaigns/ques_campaign/'.$value->id, '<i class="fa fa-pencil"></i>','class="btn btn-primary btn-flat test-proxy"') ?>
												<a data-target="#edit_proxy" data-toggle="modal" class="btn btn-info btn-flat edit" title="Export report"><i class="fa fa-fw fa-file-text-o"></i></a>
												
												<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete deleteLinkButton" title="Delete" id="<?php echo $value->id; ?>"><i class="fa fa-trash"></i> </a>
												<span id="anchor_<?php echo $value->id; ?>" style="display:none;">
													<a href="<?php echo base_url(); ?>Campaigns/delete/<?php echo $value->id; ?>" class="btn btn-default">Delete</a>
												</span>
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
<!-- Delete Modal -->
<?php echo $this->load->view('pages/delete_popup', null, true); ?>
<!-- Delete Modal -->
<!-- Modal -->
<div id="run_confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Run Campaign</h4>
      </div>
      <div class="modal-body">
        <p>Do you want to run this campaign?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <span id="campaign_run_anchor_tag_content"></span>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
$(document).ready(function (){
	$('.runcampaign').click(function() {
		var recordId = $(this).attr('id');
		var anchor_tag_html = $('#anchor_c_' + recordId).html();
		$('#campaign_run_anchor_tag_content').html(anchor_tag_html);
	});
	
});
</script>