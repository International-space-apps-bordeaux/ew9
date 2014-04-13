<?php

function create_xml($result)
{
  
    $xml = '<markers>';
    // Iterate through the rows, adding XML nodes for each
    foreach ($result as $photo){

        $xml = $xml .'<marker ';
        $xml = $xml . 'id="' . parseToXML($photo->id) . '" ';
        $xml = $xml . 'name="' . parseToXML($photo->filename) . '" ';
        $xml = $xml . 'lat="' . parseToXML($photo->latitude) . '" ';
        $xml = $xml . 'lng="' . parseToXML($photo->longitude) . '" ';
        $xml = $xml .'/>';
    }
    $xml = $xml .'</markers>';

    return $xml;
    
    
}
 // change special characteres for html
function parseToXML($htmlStr) 
{ 
    $xmlStr=str_replace('<','&lt;',$htmlStr); 
    $xmlStr=str_replace('>','&gt;',$xmlStr); 
    $xmlStr=str_replace('"','&quot;',$xmlStr); 
    $xmlStr=str_replace("'",'&#39;',$xmlStr); 
    $xmlStr=str_replace("&",'&amp;',$xmlStr); 
    return $xmlStr; 
} 


?>