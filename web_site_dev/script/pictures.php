<?php
class pictures 
{

    var $image;
    var $image_type;

    function load($filename) {

      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {

         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {

         $this->image = imagecreatefrompng($filename);
      }
     }
     function save($filename,$image_type=IMAGETYPE_JPEG,$compression=75,$permissions=null){

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
    }
    function output($image_type=IMAGETYPE_JPEG) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image);
      }
    }
    function getWidth() {

      return imagesx($this->image);
    }
     function getHeight() {

      return imagesy($this->image);
    }
    function resizeToHeight($height) {

      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
    }
    function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
    }
    function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
    }
    function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
       imagecopyresampled($new_image,$this->image,0,0,0,0,$width,$height,$this->getWidth(),$this->getHeight());
      $this->image = $new_image;
    }      
    function geoloc ($lat,$lng)
    {
             

        $stringAPIGoogle = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='. $lat .','. $lng .'&sensor=true&key=AIzaSyBLRnFhu7ruRX9BO-ql9JhTseSgDCC2IDM';

         

        $json = file_get_contents($stringAPIGoogle);

        $json_data = json_decode($json, true);

         

        $resultLoc1 =explode(",",$json_data["results"][3]['formatted_address']);

        $resultLoc2 =explode(",",$json_data["results"][4]['formatted_address']);

         
        $loca = array();
        $loca[]= trim($resultLoc1[0]);
        $loca[]= trim($resultLoc1[1]);
        $loca[]= trim($resultLoc2[0]);

        // array with
        return  $loca;
        
    }
}