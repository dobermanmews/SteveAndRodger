<?php
  // Calculate the image name and return it

  // Current is the current image index
  $current = $_GET["current"];

  // Move is the increment to move
  $move = $_GET["move"];

  // Destination tag
  $destination = $_GET["destination"];

  // We look for images in $destination."_gallery"
  $pathToImages = "images/".$destination."_gallery/";

  // File with captions and header info
  $local_xml = simplexml_load_file($destination.'.xml');

  // Read the captions
  $captions = $local_xml->xpath("caption");

  // open the gallery directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  $files = array();
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      array_push( $files, $fname );
    }
  }

  // close the directory
  closedir( $dir );
  sort( $files );

  // increment the counter
  $current = $current + $move;
  if( $current < 0 ) { $current = count($files)-1; }
  if( $current >= count($files) ) { $current = 0; }

  // get the image name
  $currentImage = $pathToImages.$files[$current];

  // return all the information using JSON notation
  $retData = array( "destination" => $destination, 
		    "current" => $current,
		    "imageName" => $currentImage,
		    "caption"  => (string)$captions[$current] );

  echo json_encode($retData);
?>
