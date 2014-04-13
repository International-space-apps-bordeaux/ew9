<?php
class tbl_images extends db
{
	private $id;
	private $filename;
	private $datetime_acquire;
	private $latitude;
	private $longitude;
	private $city;
	private $area;
	private $country;
	private $fk_depots;
	private $fk_notes;
	
	public $db;
	
	public function tbl_images($db, $id = 0)
	{
		$this->db = $db;
		
		if ($id > 0)
		{
			$this->id = intval($id);
			$sql = "SELECT * FROM images where id = '" . $this->id . "'";
			$recordset = $this->db->select($sql);
			
			$this->setfilename($recordset[0]['filename']);
			$this->setDatetime($recordset[0]['acquisition_time']);
			$this->setLatitude($recordset[0]['latitude']);
			$this->setLongitude($recordset[0]['longitude']);
			$this->setDepot($recordset[0]['fk_depot']);
			$this->setNote($recordset[0]['fk_notes']);
			$this->setCity($recordset[0]['city']);
			$this->setArea($recordset[0]['area']);
			$this->setCountry($recordset[0]['country']);
		}
	}

	public function lister()
	{
		$sql = "SELECT * FROM images";
		$recordset = $this->db->select($sql);
		
		return $recordset;
	}
	
	public function hydrate()
	{
		//$location = $this->geoloc();
		$location[0] = "area";
		$location[1] = "country";
		$location[2] = "city";

		//$this->setArea($location[0]);
		//$this->setCountry($location[1]);
		//$this->setCity($location[2]);
	}

    public function findpicture($name)
	{
		$sql = "SELECT * FROM images WHERE filename = '" . $name. "'";
		
		$recordset = $this->db->select($sql);
        		
		return $recordset;
	}
	
	public function translate($filename)
	{
		$datetime="";      
        $longitude="";
        $latitude="";
        $name="";
		$datetime .= substr($filename, 3, 4);
		$datetime .= "-";
		$datetime .= substr($filename, 7, 2);
		$datetime .= "-";
		$datetime .= substr($filename, 9, 2);
		$datetime .= " ";
		$datetime .= substr($filename, 11, 2);
		$datetime .= ":";
		$datetime .= substr($filename, 13, 2);
		$datetime .= ":";
		$datetime .= substr($filename, 15, 2);
        #LAT
		$latitude .= substr($filename, 17, 2);
        $latitude .=".";
        $latitude .=substr($filename, 19, 2);
        $this->latitude =$latitude;
        #LONG
        $longitude .= substr($filename, 22, 3);
        $longitude .=".";
        $longitude .=substr($filename, 25, 2);
		$this->longitude =$longitude;
        #NAME
        $name .=substr($filename, 0, 28);
        $name .= ".jpg";
		$this->setFilename($name);
		$this->setDatetime($datetime);
	}
	
    function geoloc ()
    {
		$lat = $this->getLatitude();
		$lng = $this->getLongitude();
		
        $stringAPIGoogle = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='. $lat .','. $lng .'&sensor=true&key=AIzaSyBLRnFhu7ruRX9BO-ql9JhTseSgDCC2IDM';

        $json = file_get_contents($stringAPIGoogle);

        $json_data = json_decode($json, true);
		var_dump($json_data); 	
		
		if ( strpos($json_data["results"][3]['formatted_address'],',') !== false)
		{
        $resultLoc1 =explode(",",$json_data["results"][3]['formatted_address']);
		}
		if ( strpos($json_data["results"][4]['formatted_address'],',') !== false)
		{
        $resultLoc2 =explode(",",$json_data["results"][4]['formatted_address']);
		}

		$loca = array();
		if ( $resultLoc1 != null)
		{
		if (count($resultLoc1) != 0)
		{
        
        $loca[]= trim($resultLoc1[0]);
        $loca[]= trim($resultLoc1[1]);
        $loca[]= trim($resultLoc2[0]);
		
		}
		}

        return  $loca;
    }
	
	public function record()
	{
        
		if ( isset($this->id))
		{
			$sql = "UPDATE images SET";
			$sql .= " filename = '". $this->getFilename ."'";
			$sql .= " acquisition_time = '". $this->getDatetime ."'";
			$sql .= " latitude = '". $this->getLatitude ."'";
			$sql .= " longitude = '". $this->getLongitude ."'";
			$sql .= " fk_depot = '". $this->getDepot ."'";
			$sql .= " fk_notes = '". $this->getNote ."'";
			$sql .= " city = '". $this->getCity ."'";
			$sql .= " area = '". $this->getArea ."'";
			$sql .= " country = '". $this->getCountry ."'";
			$sql .= " WHERE id = '" . $this->id . "'";
		}
		else
		{
            $sql = "INSERT INTO images (filename, acquisition_time, latitude, longitude, fk_depot)";
			$sql .= " VALUES ('" . $this->filename . "', '" . $this->datetime_acquire . "', '" . $this->latitude . "', '" . $this->longitude . "', '" . $this->fk_depot . "')";
            $recordset = $this->db->insert($sql);
			
			$sql = "SELECT id FROM images ORDER BY id DESC";
			$recordset = $this->db->select($sql);
			$this->id = $recordset[0]['id'];
			
            $sql = "INSERT INTO notes (image_id)";
			$sql .= " VALUES ('" . $this->id . "')";
            $recordset = $this->db->insert($sql);
			
			$sql = "SELECT id FROM notes ORDER BY id DESC";
			$recordset = $this->db->select($sql);
			$id_note = $recordset[0]['id'];
			
            $sql = "UPDATE images SET fk_notes = '". $id_note . "'";
			$sql .= " WHERE id = '" . $this->id . "'";
            $recordset = $this->db->update($sql);
		}
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function setDatetime($val)
	{
		$this->datetime_acquire = $val;
	}

	public function getFilename()
	{
		return $this->filename;
	}
	
	public function setFilename($val)
	{
        $this->filename = $val;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}
	
	public function setLatitude($val)
	{
		$this->Latitude = $val;
	}

		public function getLongitude()
	{
		return $this->longitude;
	}
	
	public function setLongitude($val)
	{
		$this->longitude = $val;
	}
	
	public function setCity($val)
	{
		$this->city = $val;
	}
	
	public function setArea($val)
	{
		$this->area = $val;
	}
	
	public function setCountry($val)
	{
		$this->country = $val;
	}

	public function setDepot($val)
	{
		$this->fk_depot = $val;
	}
	
	public function setNote($val)
	{
		$this->fk_notes = $val;
	}
}
?>