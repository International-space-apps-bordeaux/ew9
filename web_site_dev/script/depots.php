<?php 

class depots
{
	private $path;
	private $id;
	private $server;
	
	public $db;
	
	public function depots($db)
	{
		$this->db=$db;
	}
	
	public function getId()
	{
		return $this->id;
	}

	public function getPath()
	{
		$this->path;
	}
	
	public function getServer()
	{
		$this->server;
	}
	
	public function lister()
	{
		$sql = " SELECT * FROM depots";
		$recordset = $this->db->select($sql);
		return $recordset;
	}
}

?>
