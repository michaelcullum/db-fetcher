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

include($root_path . 'includes/update_db' . $phpEx);

$custom_actions = $queries;
unset($queries);

$update_db = new update_db($root_path, $phpEx);

// Connect to base DB
$update_db->connect('base', $basehost, $baseport, $basename, $baseuser, $basepasswd);
$update_db->connect('target', $targethost, $targetport, $targetname, $targetuser, $targetpasswd);
