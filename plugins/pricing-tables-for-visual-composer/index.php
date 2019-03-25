<?php 

	/*
	Plugin Name: Pricing Tables For Visual Composer - Free
	Description: Display pricing with flat,responsive tables in a easy way.
	Plugin URI: http://webdevocean.com
	Author: Labib Ahmed
	Author URI: http://webdevocean.com
	Version: 1.1
	License: GPL2
	Text Domain: wdo-pricing-tables
	*/
	
	/*
	
	    Copyright (C) 2016  Labib Ahmed  labib@najeebmediagroup.com
	*/
	include 'plugin.class.php';
	if (class_exists('VC_WDO_Pricing_Tables')) {
	    $obj_init = new VC_WDO_Pricing_Tables;
	}

 ?>