<?php 
session_start();
include("../models/model.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
// include("../includes/language.php");
// if(isset($_SESSION['language'])){
//  $htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
// }else{
//  $htmlCombo=$bsiCore->getbsilanguage(); 
// }
?>

<?php
// code is hotel_id id
$code = $_GET['code'];
$Hostel = new Model('bsi_hotels', 'hotel_id');
$RoomType = new Model('bsi_roomtype', 'roomtype_id');
$PricePlan = new PriceModel();
$Reservation = new Model('bsi_reservation', 'id');
$Rooms = new Rooms();


$hostel_content = $Hostel->find( $code );
//var_dump($hostel);
$roomtype_object = $RoomType->find_by( 'hotel_id',$code );
$roomtype_tempobject = new ArrayObject($roomtype_object);
$roomtype_content = $roomtype_tempobject->getArrayCopy(); 
// var_dump($roomtype_object);
$price_object = $PricePlan->priceplan_find_by('hotel_id', $code);
$price_tempobject = new ArrayObject($price_object);
$price_content = $price_tempobject->getArrayCopy(); 
// var_dump($price_content);
//$rooms = $Rooms->get_reserve($hostel['hotel_id'], $code);
?>
hotel id <?= $code?>
<h3><?= $hostel_content['hotel_name'] ?></h3>
<p class="address"><?= $hostel_content['address_1'].$hostel_content['address_2']?></p>

<?= $roomtype_content[0]['type_name']?> 

<a href="../bookings/new.php?code=<?= $roomtype_content[0]['roomtype_id']?>"><?= $price_content[0]['sun']?></a>
<br>
<?= $roomtype_content[1]['type_name']?> 
<a href="../bookings/new.php?code=<?= $roomtype_content[1]['roomtype_id']?>"><?= $price_content[1]['sun']?></a>