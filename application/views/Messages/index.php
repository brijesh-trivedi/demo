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
			<span class="btn btn-primary btn-xs margin-bottom "><?php echo _('Total messages'); ?>: <span>4627</span></span>
			<span class="btn btn-success btn-xs margin-bottom"><?php echo _('Text messages'); ?> : <span>4465</span></span>
			<span class="btn btn-success btn-xs margin-bottom"><?php echo _('Media messages'); ?> : <span>162</span></span>
		</section>
	</div>
	<!-- End status -->
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
									<th><?php echo _('From'); ?></th>
									<th><?php echo _('To Sender'); ?></th>
									<th><?php echo _('Type'); ?></th>
									<th><?php echo _('Content'); ?></th>																								
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
								<tr>
									<td>2015-06-15 17:51:02</td>
									<td>mohdzishanali007 (918712744304-1433794745) | <br/><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-eye-slash"></i> Add to blacklist') ?></td>
									<td>2348174651106</td>
									<td>media</td>
									<td><?php echo anchor('Messages/index/#', '<i class="fa fa-fw fa-link"></i> Link') ?></td>														
								</tr>
						</table>
					</div>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>