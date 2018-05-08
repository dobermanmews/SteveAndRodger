 <?php 
$destination = $_GET["destination"];
$local_xml = simplexml_load_file($destination.'_videos.xml');
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
        <META NAME="ROBOTS" CONTENT="noindex">
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
    echo "<BR>Return to the picture gallery <A href=\"gallery.php?destination=".$destination ."\">here.</A>";
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
  if( $i%2 == 0 )
  {
    echo "<TR VALIGN=CENTER> <TD WIDTH=40%>";
    echo "<P><FONT FACE=\"Trebuchet MS, sans-serif\">".$details[0]."</FONT><BR></P>";
    echo "</TD><TD WIDTH=40%>";
    echo "<P><VIDEO SRC=\"".$details[1]. "\" CONTROLS ALIGN=LEFT HEIGHT=320 BORDER=0><BR></P>";
    echo "</TD></TR>";
  } else {
    echo "<TR VALIGN=CENTER> <TD WIDTH=47%>";
    echo "<P><VIDEO SRC=\"".$details[1]. "\" CONTROLS ALIGN=LEFT HEIGHT=320 BORDER=0><BR></P>";
    echo "</TD><TD WIDTH=33%>";
    echo "<P><FONT FACE=\"Trebuchet MS, sans-serif\">".$details[0]."</FONT><BR></P>";
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