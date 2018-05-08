 <?php 
function createGallery( $destination, $pathToImages, $pathToThumbs, $start, $end ) 
{
  $local_xml = simplexml_load_file($destination.'.xml');
  $index_xml = simplexml_load_file('index.xml');
  $output .= "<table cellspacing=\"0\" cellpadding=\"4\" width=\"100%\">";

  $output .= "<tr>";
  
  // open the directory
  $dir = opendir( $pathToThumbs );

  $result = $local_xml->xpath("caption");

  $files = array();

  // loop through the directory
  $counter = 0;
  while (false != ($fname = readdir($dir)))
  {
    // parse path for the extension
    $info = pathinfo($pathToThumbs . $fname);

    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' ) 
    {
      if( $counter >= $start && $counter <= $end )
	{
	  array_push( $files, $fname );
	}
      $counter += 1;
    }
  }
  // close the directory
  closedir( $dir );

  asort( $files );

  $counter = 0;
  foreach( $files as $fname )
    {
      $j = $start + $counter;
      $output .= "<td valign=\"middle\" align=\"center\"><a href=\"scroller.php?destination={$destination}&current={$j}\">";
      $output .= "<img src=\"{$pathToThumbs}{$fname}\" border=\"0\" />";

      $caption = $result[$j];
      $output .= "</a><BR><FONT FACE=\"Trebuchet MS, sans-serif\">".$caption."</FONT></td>";

      $counter += 1;
      if ( $counter % 3 == 0 ) { $output .= "</tr><tr>"; }
  }

  $output .= "</tr>";
  $output .= "</table>";

  return $output;
}

$destination = $_GET["destination"];
$dest = $destination."_gallery/";
$local_xml = simplexml_load_file($destination.'_maps.xml');
$index_xml = simplexml_load_file('index.xml');
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
<TABLE WIDTH=100% BORDER=1 CELLPADDING=4 CELLSPACING=0 STYLE="page-break-before: always">
	<COL WIDTH=51*>
	<COL WIDTH=121*>
	<COL WIDTH=85*>
	<TR>
		<TD COLSPAN=3 WIDTH=100% VALIGN=TOP>
			<P ALIGN=CENTER><FONT FACE="Trebuchet MS, sans-serif" SIZE=7 STYLE="font-size: 66pt">
<?php
	$result = $local_xml->xpath("title");
	$fresult = $local_xml->xpath("flag");
        $fresult_r = $local_xml->xpath("flag_right");
        if( count($fresult_r) == 0 )
	  {
	    $fresult_r = $fresult;
	  }
        echo"<img src=\"".$fresult[0]."\" ALIGN=\"LEFT\"/>";
        echo "<img src=\"".$fresult_r[0]."\" ALIGN=\"RIGHT\"/>";
        echo $result[0];
?>
        </FONT></P>
		</TD>
	</TR>
	<TR VALIGN=TOP>
<?php
	$result = $local_xml->xpath("entry");
        $n = count($result);
        $n = $n + 1;
        echo "<TD ROWSPAN=".$n." WIDTH=20%>";
?>
			<DIV ID="TestSection" DIR="LTR">
				<P ALIGN=CENTER><FONT FACE="Trebuchet MS, sans-serif">
 <?php 
$result = $index_xml->xpath("index/trip");
foreach( $result as $trip ) { 
  $details = $trip->children();
  echo "<A href=\"".$details[1]."\">" . $details[0] . "</A><BR>";
 } 
?> 
<BR>
				</FONT></P>
			</DIV>
		</TD>
		<TD COLSPAN=2 WIDTH=80%>
			<P><FONT FACE="Trebuchet MS, sans-serif">
<?php 
$result = $local_xml->xpath("headertext");
$r0 = str_replace( "_LEFT_", "<", $result[0]);
$r1 = str_replace( "_RIGHT_", ">", $r0 );
$r2 = str_replace( "_Q_", "\"", $r1 );
$r3 = str_replace( "_AND_", "&", $r2 );
 echo $r3;
if( file_exists( "images/".$destination."_gallery" ) )
  {
    echo "<BR>You'll find all the pictures in the gallery <A href=\"gallery.php?destination=".$destination ."\">here.</A>";
  }
?> 
<BR>
			</FONT></P>
		</TD>
	</TR>
<?php
$result = $local_xml->xpath("entry");
$i = 0;
foreach( $result as $entry ) { 
  $details = $entry->children();
  $r0 = str_replace( "_LEFT_", "<", $details[0]);
  $r1 = str_replace( "_RIGHT_", ">", $r0 );
  $r2 = str_replace( "_Q_", "\"", $r1 );
  $r3 = str_replace( "_AND_", "&", $r2 );

  $l0 = str_replace( "_LEFT_", "<", $details[1]);
  $l1 = str_replace( "_RIGHT_", ">", $l0 );
  $l2 = str_replace( "_Q_", "\"", $l1 );
  $l3 = str_replace( "_AND_", "&", $l2 );

  if( $i%2 == 0 )
  {
    echo "<TR VALIGN=CENTER> <TD WIDTH=40%>";
    echo "<P><FONT FACE=\"Trebuchet MS, sans-serif\">".$r3."</FONT><BR></P>";
    echo "</TD><TD WIDTH=40%>";
    echo "$l3";
    echo "</TD></TR>";
  } else {
    echo "<TR VALIGN=CENTER> <TD WIDTH=47%>";
    echo "$l3";
    echo "</TD><TD WIDTH=33%>";
    echo "<P><FONT FACE=\"Trebuchet MS, sans-serif\">".$r3."</FONT><BR></P>";
    echo "</TD></TR>";
  }
  $i = $i + 1;
 }
?>
<P STYLE="margin-bottom: 0in"><BR>
</TABLE>
<?php
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
</P>
</BODY>
</HTML>