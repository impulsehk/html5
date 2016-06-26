<?php
    include("access.php");
    if(!isset($_GET['r_id'])){
	   header("location:hotel_review.php");	
	 } 
	 $pageid = 32;
	include("header.php");
	if(isset($_GET['r_id']))
	{
		$id=base64_decode($_GET['r_id']);
		$rid=$bsiCore->ClearInput($id);
		$detailviewresult=mysql_query("select brv.booking_id,brv.approved,brv.comment_positive,brv.comment_negetive,brv.review_date,bh.hotel_name,bc.first_name,bc.surname,bc.email,bc.phone,brv.rating_clean,brv.rating_comfort,brv.rating_location,brv.rating_services,brv.rating_staff,brv.rating_value_fr_money from bsi_hotel_review as brv,bsi_hotels as bh,bsi_clients as bc where brv.hotel_id=bh.hotel_id and brv.client_id=bc.client_id and review_id=".$rid);
		$rowdetailviewdata=mysql_fetch_assoc($detailviewresult);
		$totalrating=0.0;
		$totalrating+=$rowdetailviewdata['rating_clean']+$rowdetailviewdata['rating_comfort']+$rowdetailviewdata['rating_location']+$rowdetailviewdata['rating_services']+$rowdetailviewdata['rating_staff']+$rowdetailviewdata['rating_value_fr_money'];
	}
?>

<div class="flat_area grid_16">
<button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="window.location='hotel_review.php'" id="add_faq_form"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>BACK</span></button>
					<h2>Hotel Review Details</h2>
                     
				</div>
				<div class="box grid_16 round_all">
                
					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    	<table class="static" cellpadding="8">
                            <tbody>
                              
                                <tr><td style="text-align:left; width:200px"><strong>Booking ID:</strong></td><td style="text-align:left"><a href="viewdetails.php?booking_id=<?=base64_encode($rowdetailviewdata['booking_id'])?>"><?=$rowdetailviewdata['booking_id']?></a></td></tr>
                                <tr><td style="text-align:left"><strong>Hotel Name:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['hotel_name']?></td></tr>
                                <tr><td style="text-align:left"><strong>Client Name:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['first_name']?> <?=$rowdetailviewdata['surname']?></td></tr>
                                <tr><td style="text-align:left"><strong>Client Email:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['email']?></td></tr>
                                <tr><td style="text-align:left"><strong>Client Phone:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['phone']?></td></tr>
                                <tr><td style="text-align:left"><strong>Review Date:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['review_date']?></td></tr>
                                <tr><td style="text-align:left"><strong>Comment Positive:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['comment_positive']?></td></tr>
                                <tr><td style="text-align:left"><strong>Comment Negetive:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['comment_negetive']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Clean:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['rating_clean']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Comfort:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['rating_comfort']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Location:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['rating_location']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Services:</td><td style="text-align:left"><?=$rowdetailviewdata['rating_services']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Staff:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['rating_staff']?></td></tr>
                                <tr><td style="text-align:left"><strong>Rating Value For Money:</strong></td><td style="text-align:left"><?=$rowdetailviewdata['rating_value_fr_money']?></td></tr>
                                <tr><td style="text-align:left"><strong>Total Rating:</strong></td><td style="text-align:left"><?=$totalrating?></td></tr> 
                             
                            </tbody>
                              
					</div>
			</div>

			
		</div>
      </table>
    </div>
  </div>
</div>
 <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
</body></html>