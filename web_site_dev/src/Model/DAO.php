<?php

class DAO {
    // Class instance.
    protected static $instance;
    private $dbName = 'ew9';
    private $dbHost = 'ew9.spaceappsbdx.org';
    private $dbPort = '3306';
    private $dbUser = 'ew9';
    private $dbPass = 'LdWJKFFeVj7LNAsJ';
    private $connection = null;
    
    protected function __clone() {}
    
    protected function __construct() {
        if(!isset(self::$connection)){
            try {
            	$this->connection = new PDO('mysql:host='.$this->dbHost.';port='.$this->dbPort.';dbname='.$this->dbName, $this->dbUser, $this->dbPass);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }
    
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;                 
    }
    
    public function getAllMarkers(){
        $markers = array();
        
        $query = $this->connection->prepare('SELECT * FROM images;');
        $query->execute() ;
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result;
        }
        
        return $markers;
    }
    
    public function getBestImageOfMonth(){
        $markers = array();
        
        $query = $this->connection->prepare('SELECT *, MAX(note) FROM notes WHERE YEAR( date ) = YEAR( NOW( ) ) AND MONTH( date ) = MONTH( NOW()) ORDER BY date DESC  LIMIT 1');
        $query->execute() ;
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result->id;
            break;
        }
        return $markers[0];
    }
    
    public function getComment($id){
        $markers = array();
        $query = $this->connection->prepare('Select * FROM images INNER JOIN comment ON images.id = comment.image_id WHERE images.id = '. $id .' LIMIT 50;');
        $query->execute() ;
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result;
            break;
        }
        return $markers;
    }
    
    
    public function setVote($id){
        $markers = array();
        $query = $this->connection->prepare('UPDATE notes SET note= note+ 1 WHERE image_id= '.$id.'; ');
        $query->execute() ;
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result;
            break;
        }
        return $markers;
    }
    
    public function getRandomGallery(){
        $images = array();
        
        $query = $this->connection->prepare('SELECT * FROM images ORDER BY RAND();');
        $query->execute();
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $images[] = $result;
        }
        
        return $images;
    }
    
    public function getSimilarPicture($date)
    {
        $markers = array();
        $query = $this->connection->prepare('SELECT * FROM images WHERE acquisition_time BETWEEN ( DATE_SUB( "'. $date .'", INTERVAL 2 HOUR ) ) AND "'. $date .'" LIMIT 4;');
        $query->execute();
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result;
        }
        return $markers;
    }
    
    public function getImage($id){
        $markers = array();
        $query = $this->connection->prepare('Select * FROM images INNER JOIN notes ON images.id = notes.image_id WHERE images.id = '. $id .' LIMIT 1;');
        $query->execute() ;
        
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            $markers[] = $result;
            break;
        }
        return $markers[0];
    }
}