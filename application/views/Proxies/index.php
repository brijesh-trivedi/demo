<!-- Main content -->
<section class="content">
	<!-- Start buttons -->
	<div class="row"> 
		<div class="col-md-10">			
			<?php echo anchor('Proxies/test_all_proxies', 'Test proxies', 'id="test_all" class="btn btn-primary btn-flat status"') ?>
			<?php echo anchor('Proxies/index/#', 'Delete bad proxies', 'class="btn btn-danger btn-flat status"') ?>
		</div>
		<div class="col-md-2">				
			<?php echo anchor('Proxies/index/#', 'Delete bad proxies', 'class="btn btn-danger btn-flat status"') ?>
		</div>		
	</div>
	<!-- End buttons -->
	<!-- Start status -->
	<div class="row"> 
		<section class="content-header">
			<span class="btn btn-info btn-xs margin-bottom "><?php echo _('Total proxies'); ?>: <span><?php echo $counter['totalCount']; ?></span></span>
			<span class="btn btn-success btn-xs margin-bottom">
				<?php echo _('Active'); ?> : <span><?php echo $counter['activeCount']; ?></span>
			</span>
			<span class="btn btn-warning btn-xs margin-bottom"><?php echo _('Inactive'); ?> : <span><?php echo intval($counter['totalCount']) - intval($counter['activeCount']); ?></span></span>				
		</section>
	</div>
	<!-- End status -->
	<!-- Show Session Messages and Server Messages -->
	<div class="row"> 
		<?php echo showMessage(); ?>
	</div>
	<!-- End Messages -->
	<!-- Start table -->
	<div class="row">
		<div class="col-md-12">
			<div class="box">
                <div class="box-header">
					<h3 class="box-title"><?php echo _('Proxy list'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<div class="table-responsive">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><?php echo _('ID'); ?></th>
									<th><?php echo _('IP address'); ?></th>
									<th><?php echo _('Port'); ?></th>
									<th><?php echo _('Username'); ?></th>
									<th><?php echo _('Password'); ?></th>
									<th><?php echo _('Status'); ?></th>
									<th><?php echo _('Last check'); ?></th>
									<th><?php echo _('Created at'); ?></th>
									<th><?php echo _('Options'); ?></th>									
								</tr>
							</thead>
							<tbody>
								<?php
								//pr($proxyData);
								foreach ( $proxyData as $key => $value ) {
									?>
									<tr>
										<td><?php echo $value->id; ?></td>
										<td><?php echo $value->ip_address; ?></td>
										<td><?php echo $value->port; ?></td>
										<td><?php echo $value->username; ?></td>
										<td><?php echo $value->password; ?></td>
										<td align="center">
											<?php if ( $value->status == 1 ) { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-success btn-flat">
													<i class="fa fa-thumbs-o-up"></i> Active
												</button>
											<?php } else { ?>
												<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">
													<i class="fa fa-thumbs-o-down"></i> Inactive
												</button>
											<?php } ?>
										</td>
										<td><?php echo humanTiming(strtotime($value->updated_at)); ?> ago </td>
										<td><?php echo date("F j, Y, g:i a", strtotime($value->created_at)); ?></td>
										<td>
											<div class="btn-group btn-group">
												<a data-ip-port="#" data-proxy-id="7701" data-target="#test_proxy" href="<?php echo base_url(); ?>Proxies/testproxy/<?php echo $value->id; ?>" class="btn btn-primary btn-flat test-proxy" title="Test"><i class="fa fa-eye"></i></a>
												<a data-proxy-password="vBL472cc" data-proxy-username="saudalq" data-proxy-port="29842" data-proxy-ip="23.105.165.7" data-proxy-id="7701" class="btn btn-info btn-flat edit" title="Edit" href="<?php echo base_url(); ?>Proxies/edit/<?php echo $value->id; ?>"><i class="fa fa-edit"></i>
												</a>
												<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete deleteLinkButton" title="Delete" id="<?php echo $value->id; ?>"><i class="fa fa-trash"></i> </a>
												<span id="anchor_<?php echo $value->id; ?>" style="display:none;">
													<a href="<?php echo base_url(); ?>Proxies/delete/<?php echo $value->id; ?>" class="btn btn-default">Delete</a></span>													
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

<!-- Delete Modal -->
<?php echo $this->load->view('pages/delete_popup', null, true); ?>

<!-- Delete Modal -->
<script type="text/javascript">
	$("#test_all").click(function (){
		$('#test_all').html("Test proxies in progress");
		$('#test_all').attr('disabled', 'disabled');
		//$('.showLoder').show();
		//$('#opacitylow').css({'opacity': 0.5});
		//$('.showLoder').css({'opacity': 2.0});
	});
</script>

<script type="text/javascript">
	//
	// DataTables initialisation
	//
	$(document).ready(function() {
	    $('#example2').dataTable( {
	    	"ordering" : false,
	    	"searching" : false,
	        "processing": true,
	        "serverSide": true,
	        "ajax": $.fn.dataTable.pipeline( {
	            url: "<?php echo site_url('Proxies/listing'); ?>",
	            pages: 5 // number of pages to cache
	        } ),
	        "columns" : [
	        	{data: 'id'},
	        	{data: 'ip_address'},
	        	{data: 'port'},
	         	{data: 'username'},
	        	{data: 'password'},
	        	{data: 'status', sClass: 'status-col', createdCell: renderStatus},
	        	{data: 'updated_at_2'},
	        	{data: 'created_at_2'},
	        	{data: 'id', createdCell: renderActions}
	        ]
	    } );
	} );


	$('#example2').on( 'draw.dt', function () {
	    
	} );

	function renderStatus(obj, val, data) {
		var html = "";
		var jObj = $(obj);

		if( val == "1")
		{
			html = ""+
			'<button disabled="disabled" class="table-status btn btn-block btn-success btn-flat">' + 
				'<i class="fa fa-thumbs-o-up"></i> Active' +
			'</button>';
		}
		else
		{
			html = "" +
			'<button disabled="disabled" class="table-status btn btn-block btn-danger btn-flat">' +
				'<i class="fa fa-thumbs-o-down"></i> Inactive' +
			'</button>';
		}

		jObj.attr("align", "center").html(html);
	}

	function renderActions(obj, val, data) {

		var html = "";
		var jObj = $(obj);

		html = "" +
		'<div class="btn-group btn-group">'+
			'<a data-ip-port="#" data-proxy-id="7701" data-target="#test_proxy" href="<?php echo base_url(); ?>Proxies/testproxy/'+ val +'" class="btn btn-primary btn-flat test-proxy" title="Test"><i class="fa fa-eye"></i></a>' +
			'<a data-proxy-password="vBL472cc" data-proxy-username="saudalq" data-proxy-port="29842" data-proxy-ip="23.105.165.7" data-proxy-id="7701" class="btn btn-info btn-flat edit" title="Edit" href="<?php echo base_url(); ?>Proxies/edit/'+ val +'"><i class="fa fa-edit"></i>' +
			'</a>' +
			'<a data-target="#delete_confirm" data-toggle="modal" class="btn btn-danger btn-flat delete deleteLinkButton" title="Delete" id="'+ val +'"><i class="fa fa-trash"></i> </a>' +
			'<span id="anchor_'+ val +'" style="display:none;">' +
				'<a href="<?php echo base_url(); ?>Proxies/delete/'+ val +'" class="btn btn-default">Delete</a></span>' +
		'</div>';

		jObj.html(html);
	}

</script>