<?php

class ftp
{

    private $conn_ftp;
    private $ftp_user_name;
    private $ftp_user_pass;
    private $datab;
    private $mypath;
    private $pathid;
    #private $allFiles;
    
    
    public function ftp()
    {
        $this->ftp_user_name="anonymous";
        $this->ftp_user_pass="";
        
    }
    
    public function ftp_connection($ftp_server)
    {
        
        
        //open connection
        
        $this->conn_ftp = ftp_connect($ftp_server)or die ("can't connect to server $ftp_server");
        $login_result = ftp_login($this->conn_ftp, $this->ftp_user_name, $this->ftp_user_pass);

        

    }
    public function list_pictures ($path)
    {
        $contents=ftp_nlist($this->conn_ftp, $path);
        return $contents;
      
    }
    public function list_directories ($path)
    {
		return ftp_rawlist($this->conn_ftp, $path, true);
	}
    
    

    // ftp_sync - Copy directories
    function ftp_sync ($dir, $db,$id) 
    {
        $this->datab=$db;
        $this->pathid=$dir;
        $this->mypath=$id;
        if ($dir != ".") 
        {
            if (ftp_chdir($this->conn_ftp, $dir) == false) {
                return;
            }
        }

        $contents = ftp_nlist($this->conn_ftp, ".");
        foreach ($contents as $file) 
        {
            
       
            if ($file == '.' || $file == '..')
                continue;
           
            if (@ftp_chdir($this->conn_ftp, $file)) 
            {
                ftp_chdir ($this->conn_ftp, "..");
                $this->ftp_sync ($file,$this->datab,$this->mypath);
            }
            else
            {
                $fichier = new tbl_images($this->datab);
                $name="";
                $name .=substr($file, 0, 28);
                $name .= ".jpg";
                $test = $fichier->findpicture($name);
                
                if (!is_array($test))
                {
                    $picture = new pictures();
                    $pictureavg = new pictures();
                    ftp_get($this->conn_ftp,"../files/tmp/".$file, $file,FTP_BINARY);
                    // Uncompress file
                    $exec = "unzip ../files/tmp/". $file ." -d ../files/tmp/";
                    exec($exec);
                    $picture->load("../files/tmp/$name");
                    $picture->resize(150,150);
                    $newname="";
                    $newname .=substr($file, 0, 28);
                    $newname .= "_min.jpg";
                    $picture->save("../files/tmp/$newname");
                    $pictureavg->load("../files/tmp/$name");
                    $pictureavg->resize(1980,869);
                    $avgname="";
                    $avgname .=substr($file, 0, 28);
                    $avgname .= "_avg.jpg";
                    $pictureavg->save("../files/tmp/$avgname");
                    $cp="mv ../files/tmp/*.jpg ../files/iserv/";
                    
                    
                    exec($cp);
                         
                    
                    $fichier->setDepot($this->mypath);
                    $fichier->translate($file);
                    $fichier->hydrate();
                    $fichier->record();
                }
            }
        }
           
        ftp_chdir ($this->conn_ftp, "..");
        
    } 


  

      
    public function get_file($path, $filename)
    {
		ftp_get($this->conn_ftp, "../files/tmp/".$filename, $path."/".$filename, FTP_BINARY);
    }

}