<?php
session_start(); 
include("includes/db.conn.php");
if(base64_decode($_REQUEST['hotelcity']) == 'All Cities'){
   $cityname = NULL;
   $sql4 = mysql_query("select * from bsi_hotels where status = 1 ");	
}else{
   $cityname = mysql_real_escape_string(base64_decode($_REQUEST['hotelcity']));
   $sql4 = mysql_query("select * from bsi_hotels where city_name='$cityname' && status=1");	
}
?>
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
 <title>Google Map API V3 with markers</title>
 <style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 /*#map { width: 280px; height: 282px; border: 0px; padding: 0px; }*/
  #map { width: 100%; height: 100%; border: 0px; padding: 0px; }
 </style>
 <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
 <script type="text/javascript">
 //Sample code written by August Li
 var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/truck.png",
 new google.maps.Size(32, 32), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();
 var pt2;
  
<?php
 $hotelexist=mysql_num_rows($sql4);
 //$hotelexist=0;
  while ($row4 = mysql_fetch_assoc($sql4)){
?>
       var pt2 = new google.maps.LatLng(<?php echo $row4['latitude'];?>, <?php echo $row4['longitude']; ?>);
	   bounds.extend(pt2);
	   
<?php  }?>
//bounds.extend(bounds);
// alert (bounds);
 function addMarker(lat, lng, info, number_pos) {
 var pt = new google.maps.LatLng(lat, lng);
 <?php
 if($hotelexist){
 }else{
	 echo "bounds.extend(pt);";
 }
?>
//bounds.extend(pt);

 var marker = new google.maps.Marker({
 position: pt,
 //icon: 'http://chart.apis.google.com/chart?chst=d_map_spin&chld=1|30|00FFFF|24|_|'+number_pos,
 icon: 'images/map/marker_h.png',
 map: map
 });
 var popup = new google.maps.InfoWindow({
 content: info,
 maxWidth: 150
 });
 google.maps.event.addListener(marker, "click", function() {
 if (currentPopup != null) {
 currentPopup.close();
 currentPopup = null;
 }
 popup.open(map, marker);
 currentPopup = popup;
 });



 google.maps.event.addListener(marker, "closeclick", function() {
 map.panTo(center);
 currentPopup = null;
 });


 }
 function initMap() {
 map = new google.maps.Map(document.getElementById("map"), {
 center: new google.maps.LatLng(0, 0),
 zoom: 3,
 mapTypeId: google.maps.MapTypeId.ROADMAP,
 mapTypeControl: false,
 mapTypeControlOptions: {
 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
 },
 navigationControl: true,
 navigationControlOptions: {
 style: google.maps.NavigationControlStyle.LARGE
 }
 });
 <?php 
 if($hotelexist){
	 if($cityname == NULL){
		 $sql = mysql_query("select * from bsi_hotels");	
	 }else{
		 $sql = mysql_query("select * from bsi_hotels where city_name='$cityname'");	
	 }
 $point_total=mysql_num_rows($sql);
 $i=1;
 while ($row = mysql_fetch_assoc($sql)){
 $address='<b>'.$row['hotel_name'].'</b><br/>'.$row['address_1'].'<br/>'.$row['city_name'].', '. $row['state'].'-'.$row['post_code'].'';
 $lat=$row['latitude'];
 $lon=$row['longitude'];
 echo ("addMarker($lat, $lon,'$address','".$row['hotel_id']."');\n");
 $i++;
 }
 }
 ?>
 //center = bounds.getCenter();
 //map.fitBounds(bounds);
 //map.setZoom(3);
//alert (bounds);




<?php if ($point_total >1  ){ 
echo "map.fitBounds(bounds);";
?>

//alert(curZoom);
<?php
} else { ?>
  map.setCenter(bounds.getCenter());
  map.setZoom(10);
   
<?php } ?>

 }
//alert(map.getZoom());
 </script>
 </head>
 <body onLoad="initMap()" style="margin:0px; border:0px; padding:0px;">
 <div id="map"></div>

 </body>
 </html>