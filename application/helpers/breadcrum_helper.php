<?php

if ( !function_exists('generateBreadcrumb') ) {

	/**
	 * generateBreadcrumb method
	 * @return string
	 */
	function generateBreadcrumb() {
		$ci = &get_instance();
		$i = 1;
		$uri = $ci->uri->segment($i);
		$title = '';
		if ( $uri != "" ) {
			$title = $ci->uri->segment($i);
		} else {
			$title = 'Dashboard';
		}
		$link = '
  <section class="content-header">
      <h1>' . $title . '<small> Manage ' . $title . '</small></h1>
  <ol class="breadcrumb">
  <li><a href="' . site_url() . '"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
		while ( $uri != '' ) {
			$prep_link = '';
			for ( $j = 1; $j <= $i; $j++ ) {
				$prep_link .= $ci->uri->segment($j) . '/';
			}
			if ( $ci->uri->segment($i + 1) == '' ) {
				$link.='<li class="active"><a href="' . site_url($prep_link) . '">';
				$link.=ucwords(str_replace("_", " ", $ci->uri->segment($i))) . '</a></li> ';
			} else {
				$link.='<li><a href="' . site_url($prep_link) . '">';
				$link.=ucwords(str_replace("_", " ", $ci->uri->segment($i))) . '</a></li> ';
			}

			$i++;
			$uri = $ci->uri->segment($i);
		}
		$link .= '</ol></section>';
		return $link;
	}

}
?>