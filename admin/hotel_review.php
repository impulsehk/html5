<?php 
     include("access.php");
	if(isset($_GET['r_id'])){
		include("../includes/db.conn.php");
	    include("../includes/conf.class.php");
		$id=base64_decode($_GET['r_id']);
		$rid=$bsiCore->ClearInput($id);
		$rowapproved=mysql_fetch_assoc(mysql_query("select approved from bsi_hotel_review where review_id=".$rid));
		if($rowapproved['approved']==1){
			mysql_query("update bsi_hotel_review set approved='0' where review_id=".$rid);
			header("location:hotel_review.php");
		}else{
			mysql_query("update bsi_hotel_review set approved='1' where review_id=".$rid);
			header("location:hotel_review.php");
		}
	}
	$pageid = 32;
	include("header.php");
?>
  <div class="flat_area grid_16">
    <h2>Hotel Review</h2>
  </div>
  <div class="box grid_16 round_all">
      <table class="display datatable">
        <thead>
          <tr>
            <th>Review ID</th>
            <th style="width:130px">Hotel Name</th>
            <th style="width:120px">Client Name</th>
            <th>Client Email</th>
            <th style="width:80px">Client Phone</th>
            <th style="width:80px">Total Rating</th>
            <th style="width:150px"></th>
          </tr>
        </thead>
        <?php
			$hotelreviewresult=mysql_query("select brv.review_id, brv.approved, bh.hotel_name, bc.first_name, bc.surname,bc.email, bc.phone, brv.rating_clean, brv.rating_comfort, brv.rating_location, brv.rating_services, brv.rating_staff, brv.rating_value_fr_money from bsi_hotel_review as brv, bsi_hotels as bh, bsi_clients as bc where brv.hotel_id=bh.hotel_id and brv.client_id=bc.client_id");
 			$totalrating=0.0;				
			while($rowreviewdata=mysql_fetch_assoc($hotelreviewresult)){	
				$totalrating+=$rowreviewdata['rating_clean']+$rowreviewdata['rating_comfort']+$rowreviewdata['rating_location']+$rowreviewdata['rating_services']+$rowreviewdata['rating_staff']+$rowreviewdata['rating_value_fr_money'];
?>
        <tbody>
        <tr>
        <td><?=$rowreviewdata['review_id']?></td>
        <td><?=$rowreviewdata['hotel_name']?></td>
        <td><?=$rowreviewdata['first_name']?> <?=$rowreviewdata['surname']?></td>
        <td><?=$rowreviewdata['email']?></td>
        <td><?=$rowreviewdata['phone']?></td>
        <td><?=number_format($totalrating,2)?></td>
        <td style="text-align:right; padding:0px 6px 0px 0px"><a href="clientview.php?r_id=<?=base64_encode($rowreviewdata['review_id'])?>">View Details</a> | <a href="<?=$_SERVER['PHP_SELF']?>?r_id=<?=base64_encode($rowreviewdata['review_id'])?>"><?php if($rowreviewdata['approved']==0){echo "UnApproved";}else{echo "Approved";}?></a></td>
        </tr>
        </tbody>
        <?php
		   }
		 ?>
      </table>
   </div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
</div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
</body></html>