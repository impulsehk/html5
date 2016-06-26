<?php 

	include("access.php");

	if(isset($_GET['id'])){

		include("../includes/db.conn.php");

		include("../includes/conf.class.php");

		$pid=$bsiCore->ClearInput($_GET['id']);

		mysql_query("delete from `bsi_promocode` where promo_id=".$pid);

		header("location:discount_coupon.php");

	}

	if(isset($_POST['act_cou'])){

		include("../includes/db.conn.php");

		include("../includes/conf.class.php");

		include("../includes/admin.class.php");

		$bsiAdminMain->discountCouponInsert();

		header("location:discount_coupon.php");

	}

	$pageid = 31;

	include("header.php");

	$gethtml=$bsiAdminMain->discountCouponshow();

?>

<script type="text/javascript" src="js/jquery.validate_pp.js"></script>




<script type="text/javascript">

$(document).ready(function(){

 	$.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });
    $("#chk_expire").datepicker({
        minDate: 0,
       maxDate: "+365D",
	  numberOfMonths: 1,
	 onSelect: function(selected) {



		  var date = $(this).datepicker('getDate');



      	  if(date){



              date.setDate(date.getDate() + <?=$bsiCore->config['conf_min_night_booking']?>);



          }



          $("#txtToDate").datepicker("option","minDate", date)



        }



    });
 $("#chk_expire").datepicker();
 $("#datepickerImage").click(function() { 
  $("#chk_expire").datepicker("show");



 });



});

</script>

<script>

$(document).ready(function(){

	$('#dis_coupon').validate();

	$("#chk_expire").datepicker();

	$("#datepickerImage").click(function() { 

		$("#chk_expire").datepicker("show");

	});

	

	$('#coupon_category').change(function(){

		if($('#coupon_category').val() == 3){

		var querystr='actioncode=21';

			 $.post("admin_ajax_processor.php", querystr, function(data){           

				if(data.errorcode == 0){

					$('#td_cust_title').html(data.gethtml);

				}

			}, "json");

		}	

		});

	});

</script>

<div class="flat_area grid_16">

					<h2>Discount Coupon</h2>

				</div>

<div class="box grid_16 round_all">

  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>

  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

  <div class="block no_padding">

    <form name="dis_coupon" id="dis_coupon" action="<?=$_SERVER['PHP_SELF']?>" method="post">

      <table  cellpadding="4">

        <tbody>

          <tr>

            <td></td>

            <td></td>

          </tr>

          <tr>

            <td style="width:90px"><strong>Coupon Code</strong></td>

            <td><input type="text" id="coupon_code"  name="coupon_code" style="width:150px" class="required"/></td>

            <td nowrap="nowrap" style="width:110px"><strong>Discount Amount</strong></td>

            <td><input type="text"  size="13" id="discount_amt" name="discount_amt" style="width:110px" class="required number"/></td>

            <td><input type="radio" checked="checked" value="1" id="rad_discount_type" name="rad_discount_type"/>

              <strong>Persent</strong>

              <input type="radio" value="0" id="rad_discount_type" name="rad_discount_type"/>

              <strong>Fixed</strong></td>

          </tr>

          <tr>

            <td nowrap="nowrap" style="width:90px"><strong>Minimum Amount</strong></td>

            <td><input type="text"  size="13" id="min_amt" name="min_amt" style="width:110px;" class="required number"/></td>

            <td style="width:90px"><strong>Expiry date</strong></td>

            <td width="140px"><input type="text"  name="chk_expire" id="chk_expire" style="width:100px;" class="required"/>

              <span style="padding-left:3px;"><a id="datepickerImage" href="javascript:;"><img src="../img/month.png" height="18px" width="18px" style=" margin-bottom:-4px;" /></a></span></td>

            <td colspan="2"><input type="checkbox" value="1" id="chk_reusecoupon" name="chk_reusecoupon"/>

              <strong>Reuse Coupon per customer?</strong></td>

          </tr>

          <tr>

            <td style="width:90px"><strong>Coupon Allow for</strong></td>

            <td><select id="coupon_category" name="coupon_category">

                <option value="1">All customer</option>

                <option value="2">Existing all customer</option>

                <option value="3">One selected customer</option>

              </select></td>

            <td id="td_cust_title" colspan="3"></td>

          </tr>

          <tr>

            <td><input type="hidden" value="1" name="act_cou" id="act_cou"/></td>

          </tr>

          <tr>

            <td>&nbsp;</td><td><button class="button_colour round_all" id="frm_submit"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>

          </tr>

          <tr>

            <td colspan="2"><font color="#FF0000">*</font> Means Required<br /><font color="#FF0000">***</font> Means valid email</td>

          </tr>

        </tbody>

      </table>

    </form>

    <table class="static" cellpadding="5">

      <thead>

      <th style="width:80px"><strong>Coupon Code</strong></th>

        <th style="width:80px"><strong>Amount</strong></th>

        <th style="width:110px"><strong>Minimum Booking</strong></th>

        <th style="width:80px"><strong>Expires</strong></th>

        <th style="width:250px"><strong>Customer Allow</strong></th>

        <th style="width:140px"><strong>Reuse per customer</strong></th>

        <th style="width:50px"></th>

          </thead>

      <tbody id="getDiscountCoupon">

        <?=$gethtml?>

      </tbody>

    </table>

  </div>

</div>

</div>

<div style="padding-right:8px;"><?php include("footer.php"); ?></div>

</body></html>