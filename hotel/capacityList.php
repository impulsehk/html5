<?php
include ("access.php");
if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->capacity_delete(); 
		header("location:".$_SERVER['PHP_SELF']);
	}
include ("header.php");
$capacitylist = $bsiAdminMain->getCapacityDetails($_SESSION['hhid']);
?>
<div class="flat_area grid_16">
<button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_edit_Capacity.php?id=<?=base64_encode(0)?>'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Add&nbsp;&nbsp;New&nbsp;&nbsp;Room&nbsp;&nbsp;Capacity</span></button>
<h2>Hotel CapacityList</h2>
				</div>
					<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <table class="static" cellpadding="6">
                    <thead>
                    <tr>
                    <th width="60%" nowrap="nowrap">Title</th>
                    <th width="20%" nowrap="nowrap">Capacity</th>
                    <th width="20%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
					while($row = mysql_fetch_assoc($capacitylist)){
					?>
                    <tr><td align="left"><?=$row['title']?></td><td align="left"><?=$row['capacity']?></td><td align="right"><a href="add_edit_Capacity.php?id=<?=base64_encode($row['capacity_id'])?>">Edit</a>&nbsp;&nbsp;
                    |&nbsp;&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$row['capacity_id']?>">Delete</a></td></tr>
                    <?php
					}
					?>
                    </tbody>
                    </table>
                	</div>
			</div>
            </div>
       <div style="padding-right:8px;"><?php include("footer.php"); ?></div>
	</body>
</html>