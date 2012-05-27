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
	protected $root_path;
	protected $phpEx;
	protected $tables;

	public function __construct ($root_path, $phpEx)
	{
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
	}

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

	public function fetch_and_replace_process($method)
	{
		if ($this->fetch_base && $this->replace_target)
		{
			echo 'Complete, no errors';
		}
	}

	public function fetch_base()
	{
		$this->tables = mysql_list_tables($this->base_db_name, $this->base_connection);

		foreach ($this->tables as $table) 
		{
			mysql_select_db($this->base_db_name);
			$backup_file = $this->root_path . 'data/dumps/' . time() . '_' . $table .'.sql';
			$query      = "SELECT * INTO OUTFILE '$backupFile' FROM " . $table;
			$result = mysql_query($query);
		}
	}

	public function replace_target()
	{

	}

	public function custom_actions()
	{

	}

	public function drop_target()
	{
		if (mysql_drop_db($this->target_db_name, $this->target_connection))
		{
			echo 'DB Dropped';
		}
	}

	public function create_db()
	{
		if (mysql_create_db($this->target_db_name, $this->target_connection))
		{
			echo 'DB Created';
		}
	}

	public function import_sql()
	{
		foreach ($this->tables as $table) 
		{
			mysql_select_db($this->target_db_name);
			$backup_file = $this->root_path . 'data/dumps/' . time() . '_' . $table .'.sql';
			$query      = "LOAD DATA INFILE '$backupFile' INTO TABLE " . $table;
			$result = mysql_query($query);
		}
	}
}

?>
