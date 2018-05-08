 <?php 
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
        <img src="DobeStack_Left.gif" ALIGN="LEFT"/>
        <img src="DobeStack_Right.gif" ALIGN="RIGHT"/>
	About Us
        </FONT></P>
		</TD>
	</TR>
	<TR VALIGN=TOP>
        <TD WIDTH=20%>
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
			<FONT FACE="Trebuchet MS, sans-serif">
<H3 ALIGN=LEFT>Welcome to our Website!</H3>
<P ALIGN=LEFT>Check out some of our trips and other photos in the folders.</P>
<H4 ALIGN=CENTER>Home in Seattle</H4>
<P ALIGN=CENTER>
    For a video tour of the back garden in June 2009, see
    <a href="http://www.youtube.com/watch?v=lA-qw4tuQ0g">here.</a></P>
<P ALIGN=CENTER>
<img border="0" src="images/HomePage/BACKYARD2.jpg" width="400" height="300">
    </P><P ALIGN=CENTER>And On Dec 21, 2008:</P>
    <P ALIGN=CENTER>
    <img border="0" src="images/HomePage/WinterGarden.jpg" width="400" height="300"></P>
			</FONT>
		</TD>
	</TR>
</TABLE>
<P STYLE="margin-bottom: 0in"><BR>
</P>
</BODY>
</HTML>