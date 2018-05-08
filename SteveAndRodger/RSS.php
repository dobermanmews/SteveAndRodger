<?php
   // Include the file that does all the work
   include 'rssreader.php';
   $url=$_GET['url'];
   $text = RSS_Display($url, 8);
   echo $text;
?>
