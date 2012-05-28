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

	/**
	 * Connects to either the base or target db
	 * 
	 * @param  string $whichone Base or Target
	 * @param  string $host     host ip or hostname
	 * @param  string $port     mysql port
	 * @param  string $db_name  db name to use
	 * @param  string $user     username to login with
	 * @param  string $passwd   password to login with
	 * @return null
	 */
	public function connect($whichone, $host = 'localhost', $port = '3306', $db_name, $user, $passwd)
	{
		$full_host = $host . ':' . $port;

		switch ($whichone) {
			case 'base':
				$this->base_connection = mysql_pconnect($full_host, $user, $passwd);

				if (!$this->base_connection)
				{
					die('Could not connect: ' . mysql_error());
				}

				$this->base_db_name = $db_name;
			break;

			case 'target':
				$this->target_connection = mysql_pconnect($full_host, $user, $passwd);

				if (!$this->base_connection)
				{
					die('Could not connect: ' . mysql_error());
				}

				$this->target_db_name = $db_name;
			break;
		}

		return;
	}

	/**
	 * Disconnects from the database
	 * 
	 * @param string $whichone Set to base or target
	 * @return boolean True if closed correctly
	 */
	public function unconnect($whichone)
	{
		switch ($whichone) {
			default:
			case 'base':
				$result = mysql_close($this->base_connection);
			break;
			
			case 'target':
				$result = mysql_close($this->target_connection);
			break;
		}

		return $result;
	}

	private function fetch_base_tables()
	{
		$this->tables = mysql_list_tables($this->base_db_name, $this->base_connection);

		return;
	}

	/**
	 * Fetches base db and puts in a file per table in data/dumps/time()_tablename.sql
	 * 
	 * @return null
	 */
	public function fetch_base()
	{
		$this->fetch_base_tables;

		foreach ($this->tables as $table) 
		{
			mysql_select_db($this->base_db_name);

			$backup_file	= $this->root_path . 'data/dumps/' . time() . '_' . $table .'.sql';
			$mysql_query	= "SELECT * INTO OUTFILE '$backupFile' FROM " . $table;
			$result			= mysql_query($query);
		}

		return;
	}

	/**
	 * Drops the existing target db
	 * 
	 * @return null
	 */
	public function drop_target()
	{
		if (mysql_drop_db($this->target_db_name, $this->target_connection))
		{
			echo 'DB Dropped';
		}

		return;
	}

	/**
	 * Creates the new target db
	 * 
	 * @return null
	 */
	public function create_db()
	{
		if (mysql_create_db($this->target_db_name, $this->target_connection))
		{
			echo 'DB Created';
		}

		return;
	}

	/**
	 * Gets the sql files and imports it to target db
	 * @return [type] [description]
	 */
	public function import_sql()
	{
		$this->fetch_base_tables;
		
		foreach ($this->tables as $table) 
		{
			mysql_select_db($this->target_db_name, $this->target_connection);

			$backup_file		= $this->root_path . 'data/dumps/' . time() . '_' . $table .'.sql';
			$mysql_query		= "LOAD DATA INFILE '$backupFile' INTO TABLE " . $table;
			$result				= mysql_query($query);
		}

		return;
	}

	/**
	 * Performs any custom DB queries post update.
	 * @param  array $custom_actions Contains the queries to be run
	 * 
	 * @return null
	 */
	public function custom_actions($custom_actions)
	{
		foreach ($custom_actions as $query) 
		{
			mysql_select_db($this->target_db_name, $this->target_connection);
			mysql_query($query, $this->target_connection);
		}

		return;
	}
}
