<!-- Start Blacklist -->	
<section class="content">
	<div class="row">				
		<div class="col-md-12">
			<h3 class="text-center"><?php echo _('Proxies Blacklist'); ?></h3>
			<div class="box box-success">			
				<?php echo form_open('Proxies/blacklist'); ?>
				<div class="box-body">								
					<div class="form-group">									
						<label class="col-md-offset-3 col-md-2 control-label"></label>
						<div class="col-md-4">	
							<?php echo anchor('Proxies/blacklist_add_form', 'Add proxy IP to blacklist', 'class="btn btn-primary btn-flat status"') ?>							
						</div>																											
					</div><br/><br/>																			
					<div class="form-group">									
						<div class="col-md-offset-3 col-md-7">
							<div class="alert alert-info alert-dismissable alertBlacklist"> <i class="icon fa fa-warning"></i>No blacklisted proxies found in database. </div>							
						</div>																											
					</div>																				
				</div>																	
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<!-- End Add Proxy Form-->	
	<!-- Start status -->
	<div class="row"> 
		<section class="content-header">
			<div class="col-xs-9">				
				<span class="btn btn-info btn-xs margin-bottom "><?php echo _('Total blacklisted proxies'); ?>: <span>0</span></span>						
			</div>
			<div class="col-xs-3">	
				<?php echo anchor('Proxies/blacklist/#', 'Delete all blacklisy proxies', 'class="btn btn-danger btn-flat status"') ?>
			</div>
		</section>
	</div>
	<!-- End status -->
	<!-- Start table -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Blacklisted proxies'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo _('ID'); ?></th>
								<th><?php echo _('Proxy IP'); ?></th>
								<th><?php echo _('Added on'); ?></th>
								<th><?php echo _('Delete'); ?></th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>								
								<td>255.255.255.0</td>
								<td>2015-06-24 11:00:57</td>
								<td><i class="fa fa-trash-o"></i><a class="ico del" href="#">Delete</a></td>
							</tr>							
							<tr>
								<td>2</td>								
								<td>255.255.255.0</td>
								<td>2015-06-24 11:00:57</td>
								<td><i class="fa fa-trash-o"></i><a class="ico del" href="#">Delete</a></td>
							</tr>							
							<tr>
								<td>3</td>								
								<td>255.255.255.0</td>
								<td>2015-06-24 11:00:57</td>
								<td><i class="fa fa-trash-o"></i><a class="ico del" href="#">Delete</a></td>
							</tr>							
							<tr>
								<td>4</td>								
								<td>255.255.255.0</td>
								<td>2015-06-24 11:00:57</td>
								<td><i class="fa fa-trash-o"></i><a class="ico del" href="#">Delete</a></td>
							</tr>							
							<tr>
								<td>5</td>								
								<td>255.255.255.0</td>
								<td>2015-06-24 11:00:57</td>
								<td><i class="fa fa-trash-o"></i><a class="ico del" href="#">Delete</a></td>
							</tr>																									
						</tbody>						
					</table>
                </div>
			</div>
		</div>
	</div>
	<!-- End table -->
</section>
