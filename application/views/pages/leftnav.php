<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!--sidebar: style can be found in sidebar.less--> 
	<section class="sidebar">
		<!--sidCebar menu: : style can be found in sidebar.less--> 
		<ul class="sidebar-menu" >
			<li class="header">MAIN NAVIGATION</li>
			<!-- Proxy -->
			<li class="treeview<?php if ( $this->router->class == 'Proxies' ) { ?> active<?php } ?>">
				<a href="#">
					<i class="fa fa-random"></i> <span><?php echo _('Proxies'); ?></span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ( ($this->router->class == 'Proxies') && ($this->router->method == 'index') ) { ?> active<?php } ?>"><a href="<?php echo site_url('Proxies/index'); ?>"><i class="fa fa-circle-o"></i><?php echo _('View All'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Proxies') && ($this->router->method == 'add' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Proxies/add'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Add new'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Proxies') && ($this->router->method == 'import' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Proxies/import'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Import Proxies'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Proxies') && (($this->router->method == 'blacklist' )) || ($this->router->method == 'blacklist_add_form' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Proxies/blacklist'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Blacklist'); ?></a></li>
				</ul>
            </li>
			<!-- Senders -->
			<li class="<?php if ( $this->router->class == 'Senders' ) { ?> active <?php } ?>">
				<a href="#">
					<i class="fa fa-envelope-o"></i> <span><?php echo _('Senders'); ?></span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ( ($this->router->class == 'Senders') && ($this->router->method == 'index') ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/index'); ?>"><i class="fa fa-circle-o"></i><?php echo _('View All'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Senders') && ($this->router->method == 'add' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/add'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Add new'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Senders') && ($this->router->method == 'import' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/import'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Import senders'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Senders') && ($this->router->method == 'nickname' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/nickname'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Manage Nickname'); ?></a></li>										
					<li class="<?php if ( ($this->router->class == 'Senders') && (($this->router->method == 'groups' ) || ($this->router->method == 'sub_groups' ) || ($this->router->method == 'add_sender_group' )) ) { ?> active<?php } ?>">
						<a href="#">
							<i class="fa fa-circle-o"></i><?php echo _('Senders Groups'); ?> <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if ( ($this->router->class == 'Senders') && (($this->router->method == 'groups' ) || ($this->router->method == 'sub_groups' )) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/groups'); ?>"> <i class="fa -fw fa-send"></i><?php echo _('View All Sender Group'); ?></a></li>					
							<li class="<?php if ( ($this->router->class == 'Senders') && ($this->router->method == 'add_sender_group' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Senders/add_sender_group'); ?>"> <i class="fa -fw fa-send"></i><?php echo _('Add New Sender Group'); ?></a></li>					
						</ul>
					</li>					
				</ul>
			</li>				
			<!-- Recipients -->
			<li class="<?php if ( $this->router->class == 'Recipients' ) { ?> active <?php } ?>">
				<a href="#">
					<i class="fa fa-fw fa-share-square-o"></i> <span><?php echo _('Recipients'); ?></span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ( ($this->router->class == 'Recipients') && ($this->router->method == 'index') ) { ?> active<?php } ?>"><a href="<?php echo site_url('Recipients/index'); ?>"><i class="fa fa-circle-o"></i><?php echo _('View All'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Recipients') && ($this->router->method == 'add' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Recipients/add'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Add new'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Recipients') && ($this->router->method == 'import' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Recipients/import'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Import recipients'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Recipients') && ($this->router->method == 'nickname' ) ) { ?> active<?php } ?>"><a href="#"><i class="fa fa-circle-o"></i><?php echo _('Manage Nickname'); ?></a></li>					
					<li class="<?php if ( ($this->router->class == 'Recipients') && (($this->router->method == 'groups' ) || ($this->router->method == 'sub_groups' ) || ($this->router->method == 'add_recipient_group' )) ) { ?> active<?php } ?>">
						<a href="#">
							<i class="fa fa-circle-o"></i><?php echo _('Recipients Groups'); ?> <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if ( ($this->router->class == 'Recipients') && (($this->router->method == 'groups' ) || ($this->router->method == 'sub_groups' )) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Recipients/groups'); ?>"> <i class="fa -fw fa-send"></i><?php echo _('View All Recipient Groups'); ?></a></li>					
							<li class="<?php if ( ($this->router->class == 'Recipients') && ($this->router->method == 'add_recipient_group' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Recipients/add_recipient_group'); ?>"> <i class="fa -fw fa-send"></i><?php echo _('Add New Recipient Group'); ?></a></li>					
						</ul>
					</li>	
				</ul>
			</li>	
			<!-- Campaigns -->
			<li class="<?php if ( $this->router->class == 'Campaigns' ) { ?> active <?php } ?>">
				<a href="#">
					<i class="fa fa-fw fa-search"></i> <span><?php echo _('Campaigns'); ?></span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ( ($this->router->class == 'Campaigns') && (($this->router->method == 'index') || ($this->router->method == 'ques_campaign')) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Campaigns/index'); ?>"><i class="fa fa-circle-o"></i><?php echo _('View All'); ?></a></li>
					<li class="<?php if ( ($this->router->class == 'Campaigns') && ($this->router->method == 'add' ) ) { ?> active<?php } ?>"><a href="<?php echo site_url('Campaigns/add'); ?>"><i class="fa fa-circle-o"></i><?php echo _('Add new'); ?></a></li>					
				</ul>
			</li>				
			<!-- Queues -->
			<li class="<?php if ( $this->router->class == 'Queues' && $this->router->method = 'index' ) { ?> active <?php } ?>">
				<a href="<?php echo site_url('Queues/index'); ?>">
					<i class="fa fa-align-justify"></i> <span>Queues</span>
				</a>
			</li>	
			<!-- Messages -->
			<li class="<?php if ( $this->router->class == 'Messages' ) { ?> active <?php } ?>">
				<a href="#">
					<i class="fa fa-inbox"></i> <span><?php echo _('Received Messages'); ?></span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ( ($this->router->class == 'Messages') && ($this->router->method == 'index') ) { ?> active<?php } ?>"><a href="<?php echo site_url('Messages/index'); ?>"><i class="fa fa-circle-o"></i><?php echo _('View All'); ?></a></li>					
				</ul>
			</li>	
			<!-- Settings -->
			<li class="<?php if ( $this->router->class == 'Settings' && $this->router->method = 'index' ) { ?> active <?php } ?>">
				<a href="<?php echo site_url('Settings/index'); ?>">
					<i class="fa fa-fw fa-gears"></i> <span>Settings</span>
				</a>
			</li>						
		</ul>
	</section>
	<!--/.sidebar--> 
</aside>


