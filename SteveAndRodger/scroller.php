<?php
  // Gallery scroller
  // Looks up all the jpgs in the $destination."_gallery" folder
  // Each time prev/next is pressed, uses imageName.php to calculate
  // the prev/next image. Uses that information to change the innerHTML
  // of the image display area

  // $current is the initial image number.
  $current = $_GET["current"];

  // $destination is the destination indicator. We'll look in directory
  //     $destination."_gallery" for images
  $destination = $_GET["destination"];

  // $local_xml is the destination xml file with captions and header info
  $local_xml = simplexml_load_file($destination.'.xml');

  // $index_xml is the menu list
  $index_xml = simplexml_load_file('index.xml');
?>

  <HTML>
  <STYLE TYPE="text/css">
    A { text-decoration:none }
    A:hover { font-weight: bold }
  </STYLE>

  <HEAD>
  <script type="text/javascript">

  <?php
    echo "var jscurrent = $current;"
  ?>
  var httpObject = null;

  // get the HTTPObject depending on browser
  function getHTTPObject() {
    if(httpObject == null)
      {
	if (window.ActiveXObject) 
	  httpObject = new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest)
	  httpObject = new XMLHttpRequest();
	else
	  alert("Your browser does not support AJAX.");
      }
    return httpObject;
  }

  // update the inner HTML of the image area
  function setImage() {
    if( httpObject.readyState == 4){
      var response = httpObject.responseText;

      // evaluate the JSON formateed response
      var sp = eval('('+response+')');

      // update the cell
      var cell = document.getElementById('imageArea');
      cell.innerHTML = "<img src=\""+sp.imageName+"\" border=\"0\" height=\"319\" width=\"400\" /><BR>"+sp.caption+"<BR><A href=\"gallery.php?destination="+sp.destination+"\">Return to Gallery</A>";

      // update the current position
      jscurrent = sp.current;
    }
  }

  // callback function when prev/next is pressed
  function doWork(inc) {
    httpObject = getHTTPObject();
    if( httpObject != null ) {
<?php
	echo "httpObject.open(\"GET\", \"imageName.php?destination=${destination}&current=\"+jscurrent+\"&move=\"+inc, true);";
?>
      httpObject.onreadystatechange = setImage;
      httpObject.send(null);
    }
  }

  </script>
  </HEAD>

  <BODY LANG="en-US" BACKGROUND="sand-light.jpg" onload="doWork(0)">
  <FONT FACE="Trebuchet MS, sans-serif">
  <table cellspacing="0" cellpadding="2" width="100%">
  <TR><TD COLSPAN=4 WIDTH=100% ALIGN=CENTER STYLE="border-bottom: solid 1px #000">
  <FONT FACE="Trebuchet MS, sans-serif" SIZE=7 STYLE="font-size: 66pt">
<?php
  $result = $local_xml->xpath("title");
  $fresult = $local_xml->xpath("flag");
  echo "<img src=\"".$fresult[0]."\" ALIGN=\"RIGHT\"/>";
  echo "<img src=\"".$fresult[0]."\" ALIGN=\"LEFT\"/>";
  echo $result[0];
?>

  </FONT>
  </TD></TR>
  <TR><TD WIDTH=20% VALIGN=TOP ALIGN=CENTER STYLE="border-right: solid 1px #000">

<?php
  // left menu
  $result = $index_xml->xpath("index/trip");
  foreach( $result as $trip ) { 
    $details = $trip->children();
    echo "<A href=\"".$details[1]."\"><nobr>" . $details[0] . "</nobr></A><BR>";
   } 
?>

  </TD>
  <TD ALIGN=RIGHT VALIGN=CENTER>
  <!-- previous button -->
  <A onClick="doWork(-1)">
  <img border="0" src="previous.gif" width="50"></A></TD>

  <!-- image/caption. The span innerHtml gets set by scripts above -->
  <TD ALIGN=CENTER WIDTH=80%><SPAN id="imageArea"></SPAN></TD>

  <TD ALIGN=LEFT VALIGN=CENTER>
  <!-- next button -->
  <A onClick="doWork(1)">
  <img border="0" src="next.gif" width="50"></A></TD></TR>
  </table></FONT></BODY></HTML>

  <P ALIGN=CENTER>

<?php
  // bottom menu
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
