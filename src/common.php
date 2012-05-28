<?php
/**
*
* @package update_db
* @copyright (c) 2012 Michael Cullum (Unknown Bliss of http://michaelcullum.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined(IN_UPDATE))
{
	exit;
}

$queries = array();

if (file_exists($root_path . 'custom_common' . $phpEx))
{
	include($root_path . 'custom_common' . $phpEx);
}

if (!isset($config_overide))
{
	include($root_path . 'config/base_db' . $phpEx);
	include($root_path . 'config/target_db' . $phpEx);
	include($root_path . 'config/custom_actions' . $phpEx);
}

// Manually load all the classes
include($root_path . 'includes/update_db' . $phpEx);

// phpBB Request Class Lib
include($root_path . 'libs/phpBB/request/deactivated_super_global' . $phpEx);
include($root_path . 'libs/phpBB/request/interface' . $phpEx);
include($root_path . 'libs/phpBB/request/request' . $phpEx);
include($root_path . 'libs/phpBB/request/type_cast_helper' . $phpEx);
include($root_path . 'libs/phpBB/request/type_cast_helper_interface' . $phpEx);

$custom_actions = $queries;
unset($queries);

$update_db	= new update_db($root_path, $phpEx);
$request	= new phpbb_request();

// Connect to base DB
$update_db->connect('base', $basehost, $baseport, $basename, $baseuser, $basepasswd);
$update_db->connect('target', $targethost, $targetport, $targetname, $targetuser, $targetpasswd);
