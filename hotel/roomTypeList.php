<?php
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_id=$delid"));
		if($row['rtype_image'] != "" || $row['rtype_image'] != NULL) {
			unlink("../gallery/roomTypeImage/".$row['rtype_image']);
			unlink("../gallery/roomTypeImage/thumb_".$row['rtype_image']);
		}
		$_SESSION['hotel_id']=$row['hotel_id'];
		mysql_query("delete from bsi_roomtype where roomtype_id=".$delid);
		mysql_query("delete from bsi_priceplan where roomtype_id=".$delid);
		mysql_query("delete from bsi_room where roomtype_id=".$delid);
		header("location: roomTypeList.php");
	}
	include ("header.php");
	$roomtypelist = $bsiAdminMain->getRoomtypeDetails($_SESSION['hhid']);
?>
<div class="flat_area grid_16"><?php $id=base64_encode(0);?>
            <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='hotel_room_type.php?roomtype_id=<?=$id?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Add New Room Type</span></button>
					<h2>RoomType List</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
						<table cellpadding="6" class="static">
                        	<thead>
                                <tr>
                                    <th width="200px" nowrap="nowrap">Room Type</th>
                                    <th width="400px" nowrap="nowrap">Services</th>
                                    <th width="100px">&nbsp;</th>
                                </tr>
                            </thead>
                                <tbody>
                                 <?php
					while($row = mysql_fetch_assoc($roomtypelist)){
					?>
                    <tr><td align="left"><?=$row['type_name']?></td><td align="left"><?=$row['services']?></td><td align="right"><a href="hotel_room_type.php?roomtype_id=<?=base64_encode($row['roomtype_id'])?>&addedit=1">Edit</a>&nbsp;&nbsp;
                    |&nbsp;&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$row['roomtype_id']?>">Delete</a></td></tr>
                    <?php
					}
					?>
                                </tbody>
                        </table>
					</div>
			</div>
		</div>
		<div id="loading_overlay">
			<div class="loading_message round_bottom">Loading...</div>
		</div>
        <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
        </body>
	</html>