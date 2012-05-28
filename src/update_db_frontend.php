<?php
/**
*
* @package update_db
* @copyright (c) 2012 Michael Cullum (Unknown Bliss of http://michaelcullum.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

$root_path = './';
$phpEx = '.php';

define(IN_UPDATE, true);

include($root_path . 'common' . $phpEx);

$mode = $request->request('mode', 0);

if ($mode === 0) {
	echo 'Would you like to update the DB?';
	echo '<a href="./update_db_frontend' . $phpEx . '?mode=1">Yes</a>';
}
elseif ($mode === 1) 
{
	$update_db->fetch_base;
	echo '<h1> Fetching Base DB </h1>';
	echo '<a href="./update_db_frontend' . $phpEx . '?mode=2">Continue</a>';
}
elseif ($mode === 2) {
	$update_db->drop_target;
	echo '<h1> Drop Target DB </h1>';
	echo '<a href="./update_db_frontend' . $phpEx . '?mode=3">Continue</a>';
}
elseif ($mode === 3) {
	$update_db->create_db;
	echo '<h1> Creating Target DB </h1>';
	echo '<a href="./update_db_frontend' . $phpEx . '?mode=4">Continue</a>';
}
elseif ($mode === 4) {
	$update_db->import_sql;
	echo '<h1> Importing SQL File </h1>';
	echo '<a href="./update_db_frontend' . $phpEx . '?mode=5">Continue</a>';
}
elseif ($mode === 5) {
	$update_db->custom_actions;
	echo '<h1> Performing Custom Post Update Actions </h1>';
	echo '<strong>Finished</strong>';
}
