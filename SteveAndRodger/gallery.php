<?php
function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
{
  // see if destination exists
  if( !file_exists( $pathToThumbs ) )
    {
      mkdir( $pathToThumbs );
    }

  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      // skip if file already exists
      if( file_exists( "{$pathToThumbs}{$fname}" ) ) continue;

      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image 
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      $i = imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
  }
  // close the directory
  closedir( $dir );
}

function createGallery( $destination, $pathToImages, $pathToThumbs ) 
{
  $local_xml = simplexml_load_file($destination.'.xml');
  $index_xml = simplexml_load_file('index.xml');
  $output .= "<table cellspacing=\"0\" cellpadding=\"4\" width=\"100%\">";

  $output .= "<tr>";

  $output .= "<TD  COLSPAN=9 WIDTH=100% STYLE=\"border-bottom: solid 1px #000\">";
  $output .= "<P ALIGN=\"CENTER\"><FONT SIZE=7 FACE=\"Trebuchet MS, sans-serif\" STYLE=\"font-size: 66pt\">";
  $result = $local_xml->xpath("title");
  $fresult = $local_xml->xpath("flag");
  $output .= "<img src=\"".$fresult[0]."\" ALIGN=\"RIGHT\"/>";
  $output .= "<img src=\"".$fresult[0]."\" ALIGN=\"LEFT\"/>";
  $output .= $result[0];
  $output .= "</FONT></P></TD></tr>";

  $output .= "<tr>";
  
  $output .= "<TD ROWSPAN=600 WIDTH=30% VALIGN=TOP STYLE=\"border-right: solid 1px #000\">";
  $output .= "<DIV ID=\"TestSection\" DIR=\"LTR\">";
  $output .= "<P ALIGN=CENTER><FONT FACE=\"Trebuchet MS, sans-serif\">";

      $result = $index_xml->xpath("index/trip");
      foreach( $result as $trip ) { 
       $details = $trip->children();
       $output .= "<A href=\"".$details[1]."\"><NOBR>" . $details[0] . "</NOBR></A><BR>";
       }

  $output .= "<BR>";
  $output .= "</FONT></P>";
  $output .= "</DIV>";
  $output .= "</TD>";
  
  // open the directory
  $dir = opendir( $pathToThumbs );

  $result = $local_xml->xpath("caption");

  $files = array();

  // loop through the directory
  while (false !== ($fname = readdir($dir)))
  {
    // parse path for the extension
    $info = pathinfo($pathToThumbs . $fname);

    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      array_push( $files, $fname );
    }
  }
  // close the directory
  closedir( $dir );

  asort( $files );

  $counter = 0;
  foreach( $files as $fname )
    {
      $output .= "<td valign=\"middle\" align=\"center\"><a href=\"scroller.php?destination={$destination}&current={$counter}\">";
      $output .= "<img src=\"{$pathToThumbs}{$fname}\" border=\"0\" />";

      $caption = $result[$counter];
      $output .= "</a><BR><FONT FACE=\"Trebuchet MS, sans-serif\">".$caption."</FONT></td>";

      $counter += 1;
      if ( $counter % 8 == 0 ) { $output .= "</tr><tr>"; }
  }

  $output .= "</tr>";
  $output .= "</table>";

  $output .= "<P ALIGN=CENTER>";
  $result = $index_xml->xpath("index/trip");
  $c = 1;
  $cn = count($result);
  foreach( $result as $trip ) { 
     $details = $trip->children();
     $output .= "<A href=\"".$details[1]."\"><NOBR>" . $details[0] . "</NOBR></A>";
     if( $c != $cn )
     {
	$output .= " | ";
     }
     $c += 1;
  }
  $output .= "</P>";
  return $output;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=windows-1252">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="OpenOffice.org 3.1  (Win32)">
	<META NAME="AUTHOR" CONTENT="Rodger Biasca">
	<META NAME="CREATED" CONTENT="20091102;18032500">
	<META NAME="CHANGEDBY" CONTENT="Rodger Biasca">
	<META NAME="CHANGED" CONTENT="20091105;11252600">
	<STYLE TYPE="text/css">
	<!--
		@page { margin: 0.79in }
		TD P { margin-bottom: 0in }
		P { margin-bottom: 0.08in }
		A:link { so-language: zxx }
	-->
	A { text-decoration:none }
	A:hover { font-weight: bold }
	</STYLE>
</HEAD>
<BODY LANG="en-US" BACKGROUND="sand-light.jpg" DIR="LTR">
<?php
	$destination = $_GET["destination"];
        $dest = $destination."_gallery/";

	createThumbs( "images/".$dest, "thumbs/".$dest, 100);

// call createGallery function and pass to it as parameters the path 
// to the directory that contains images and the path to the directory
// in which thumbnails will be placed. We are assuming that 
// the path will be a relative path working 
// both in the filesystem, and through the web for links
$output = createGallery($destination, "images/".$dest,"thumbs/".$dest);
echo $output;
?>

</BODY>
</HTML>