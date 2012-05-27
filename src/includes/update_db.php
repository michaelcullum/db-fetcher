<?php
/**
*
* @package update_db
* @copyright (c) 2012 Michael Cullum (Unknown Bliss of http://michaelcullum.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

class update_db
{
	protected $base_connection;
	protected $target_connection;
	protected $base_db_name;
	protected $target_db_name;

	public function connect($whichone, $host = 'localhost', $port = '3306', $db_name, $user, $passwd)
	{
		$full_host = $host . ':' . $port;

		switch ($whichone) {
			case 'base':
				$this->base_connection = mysql_connect($full_host, $user, $passwd);

				if (!$this->base_connection)
				{
					die('Could not connect: ' . mysql_error());
				}

				$this->base_db_name = $db_name;
			break;
			
			case 'target':
				$this->target_connection = mysql_connect($full_host, $user, $passwd);

				if (!$this->base_connection)
				{
					die('Could not connect: ' . mysql_error());
				}

				$this->target_db_name = $db_name;
			break;
		}
	}

	public function unconnect()
	{
		mysql_close($this->base_connection);
	}
}

?>
