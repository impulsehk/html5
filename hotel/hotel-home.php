<?php
include ("access.php");//echo "<pre>";print_r($_SESSION);echo "</pre>";
include ("header.php");
$row = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);
?>
<style type="text/css">
<!--
.style1 {
	font-size: 25px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #666666;
}
-->
</style>
<div class="flat_area grid_16"> </div>
<div class="block no_padding">
  <table class="bodytext" width="100%">
    <tbody>
      <tr>
        <td height="400" valign="middle" align="center"><span class="style1">
          <?=$row['hotel_name']?>
          Panel</span></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>