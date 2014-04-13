<?php
class db
{
	private $hostname;	// MySQL Hostname
	private $port;	    // MySQL Port
	private $username;	// MySQL Username
	private $password;	// MySQL Password
	private $database;	// MySQL Database

	private $databaseLink;

	public function db()
	{
		$this->hotsname = "localhost";
		$this->port = "3306";
		$this->username = "ew9";
		$this->password = "LdWJKFFeVj7LNAsJ";
        $this->database = "ew9";
	}
	
	public function connect($persistant = false)
	{
		$this->CloseConnection();

		if($persistant)
		{
			$this->databaseLink = mysql_pconnect($this->hostname, $this->username, $this->password);
		}else{
			$this->databaseLink = mysql_connect($this->hostname, $this->username, $this->password);
		}

		if(!$this->databaseLink)
		{
			$this->lastError = 'Could not connect to server: ' . mysql_error($this->databaseLink);
			return false;
		}

		if(!$this->UseDB())
		{
			$this->lastError = 'Could not connect to database: ' . mysql_error($this->databaseLink);
			return false;
		}
		return true;
	}
	
	private function UseDB()
	{
		if(!mysql_select_db($this->database, $this->databaseLink))
		{
			$this->lastError = 'Cannot select database: ' . mysql_error($this->databaseLink);
			return false;
		}else{
			return true;
		}
	}
	
	function select($sql)
	{
		return $this->ExecuteSQL($sql);
	}
	
	function insert($sql)
	{
		return $this->ExecuteSQL($sql);
	}
	
	function update($sql)
	{
		return $this->ExecuteSQL($sql);
	}
	
	function ExecuteSQL($query)
	{
		$this->lastQuery = $query;
		if($this->result = mysql_query($query, $this->databaseLink))
		{
			@$this->records = mysql_num_rows($this->result);
			@$this->affected	= mysql_affected_rows($this->databaseLink);

			if($this->records > 0)
			{
				$this->ArrayResults();
				return $this->arrayedResult;
			}else{
				return true;
			}
		}else{
			$this->lastError = mysql_error($this->databaseLink);
			return false;
		}
	}
	
	// 'Arrays' a single result
	function ArrayResult()
	{
		$this->arrayedResult = mysql_fetch_assoc($this->result) or die (mysql_error($this->databaseLink));
		return $this->arrayedResult;
	}

	// 'Arrays' multiple result
	function ArrayResults()
	{
		if($this->records == 1)
		{
			//return $this->ArrayResult();
		}

		$this->arrayedResult = array();
		while ($data = mysql_fetch_assoc($this->result))
		{
			$this->arrayedResult[] = $data;
		}
		return $this->arrayedResult;
	}

	function CloseConnection()
	{
		if($this->databaseLink)
		{
			mysql_close($this->databaseLink);
		}
	}
}
?>