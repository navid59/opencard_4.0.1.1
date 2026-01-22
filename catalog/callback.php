<?php
/**
 * Payment Callback Handler
 * 
 * NETOPIA payment platform sends payment notifications to this file.
 * We use this file because NETOPIA rejects URLs with "|" character.
 * This file loads OpenCart and processes the payment notification.
 */

// Determine base directory (go up 4 levels from extension/mobilpay/catalog/callback.php)
$base_dir = dirname(dirname(dirname(dirname(__FILE__))));

// Change to base directory so relative paths work correctly
chdir($base_dir);

// Version
define('VERSION', '4.0.1.1');

// Load configuration first (defines constants like DIR_SYSTEM, DIR_APPLICATION, etc.)
if (is_file('config.php')) {
	require_once('config.php');
} else {
	die('Error: config.php not found!');
}

// Install check
if (!defined('DIR_APPLICATION')) {
	die('Error: OpenCart not properly configured!');
}

// Bootstrap OpenCart
require_once(DIR_SYSTEM . 'startup.php');

// Set the route to use pipe notation (framework will handle it)
$_GET['route'] = 'extension/mobilpay/payment/mobilpay|callback';

// Use OpenCart's framework to bootstrap and route
require_once(DIR_SYSTEM . 'framework.php');
