<?php
  $current = $_GET["current"];
  $destination = $_GET["destination"];
  $pathToImages = "images/".$destination."_gallery/";

  $local_xml = simplexml_load_file($destination.'.xml');
  $index_xml = simplexml_load_file('index.xml');
  $captions = $local_xml->xpath("caption");

  // open the directory
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

  $prevImage = $current-1;
  if( $prevImage < 0 ) { $prevImage = count($files)-1; }
  $currentImage = $pathToImages.$files[$current];
  $nextImage = $current+1;
  if( $nextImage >= count($files) ) { $nextImage = 0; }
  echo "<HTML>";
  echo "<STYLE TYPE=\"text/css\">";
  echo "  A { text-decoration:none }";
  echo "  A:hover { font-weight: bold }";
  echo "</STYLE>";
  echo "</HTML><BODY LANG=\"en-US\" BACKGROUND=\"sand-light.jpg\">";
  echo "<FONT FACE=\"Trebuchet MS, sans-serif\">";
  echo "<table cellspacing=\"0\" cellpadding=\"2\" width=\"100%\">";
  echo "<TR><TD COLSPAN=4 WIDTH=100% ALIGN=CENTER STYLE=\"border-bottom: solid 1px #000\">";
  echo "<FONT FACE=\"Trebuchet MS, sans-serif\" SIZE=7 STYLE=\"font-size: 66pt\">";
  $result = $local_xml->xpath("title");
  $fresult = $local_xml->xpath("flag");
  echo "<img src=\"".$fresult[0]."\" ALIGN=\"RIGHT\"/>";
  echo "<img src=\"".$fresult[0]."\" ALIGN=\"LEFT\"/>";
  echo $result[0];
  echo "</FONT>";
  echo "</TD></TR>";
  echo "<TR><TD WIDTH=20% VALIGN=TOP ALIGN=CENTER STYLE=\"border-right: solid 1px #000\">";
  $result = $index_xml->xpath("index/trip");
  foreach( $result as $trip ) { 
    $details = $trip->children();
    echo "<A href=\"".$details[1]."\"><nobr>" . $details[0] . "</nobr></A><BR>";
   } 
  echo "</TD>";
  echo "<TD ALIGN=RIGHT VALIGN=CENTER>";
  echo "<A href=\"scroller.php?destination={$destination}&current=";
  echo $prevImage;
  echo "\"><img border=\"0\" src=\"previous.gif\" width=\"50\"></A></TD>";

  echo "<TD ALIGN=CENTER WIDTH=80%><img src=\"{$currentImage}\" border=\"0\" /><BR>".$captions[$current]."<BR><A href=\"gallery.php?destination=".$destination."\">Return to Gallery</A></TD>";  

  echo "<TD ALIGN=LEFT VALIGN=CENTER>";
  echo "<A href=\"scroller.php?destination={$destination}&current=";
  echo $nextImage;
  echo "\"><img border=\"0\" src=\"next.gif\" width=\"50\"></A></TD></TR>";
  
  echo "</table></FONT></BODY></HTML>";

  echo "<P ALIGN=CENTER>";
  $result = $index_xml->xpath("index/trip");
  $c = 1;
  $cn = count($result);
  foreach( $result as $trip ) { 
     $details = $trip->children();
     echo "<A href=\"".$details[1]."\"><NOBR>" . $details[0] . "</NOBR></A>";
     if( $c != $cn )
     {
	echo " | ";
     }
     $c += 1;
  }
  echo "</P>";
?>
