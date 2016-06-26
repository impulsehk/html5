<?php 
	include("access.php");
	$pageid = 26;
	include("header.php");
?>

<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='page.editor.php?id=0'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Menu</span></button>
  <h2>Website Menu &amp; Content Manager</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <?php

	if(isset($_GET['del'])):

	mysql_query("delete from bsi_site_contents where id=".$bsiCore->ClearInput($_GET['del']));

	endif;

	?>
    <table class="static">
      <thead>
        <tr>
          <th class="first">Main Menu</th>
          <th class="first">Sub Menu</th>
          <th class="first">Sub Sub Menu</th>
          <th class="first">Order</th>
          <th class="first">Menu Type</th>
          <th class="first">Status</th>
          <th class="first">Action</th>
        </tr>
      </thead>
      <tbody id="getFaqform">
        <?php

if(!isset($_GET['limit'])){$_GET['limit']=1;}

if(isset($_POST['SBMT_SEARCH']) && $_POST['search'] && $_POST['param']=="id"):

  		$cond="id=" . $_POST['search'];		

elseif(isset($_POST['SBMT_SEARCH']) && $_POST['param'] && $_POST['search']):

 			$cond=$_POST['param']  . " rlike '" . $_POST['search'] . "'";

endif;

if(isset($cond)){$cond2=" where " . $cond;}

$j=0;$tids=array();

if(isset($_REQUEST['tid'])):

  $tids=explode("|",$_REQUEST['tid']);

endif;

$r=mysql_query("select * from bsi_site_contents where parent_id=0 order by menu,ord");


$tid='';
while($d=@mysql_fetch_array($r)):

    if(!($j%2)){$class="even";}else{$class="odd";}

	echo"<tr bgcolor=#ffffff class=even><td class='bodytext'>";

	if(in_array($d['id'],$tids)):

        echo"<a href='" . $_SERVER['PHP_SELF'] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\"><button class='skin_colour round_all'>

							<img src='images/icons/small/white/acces_denied_sign.png' width='24' height='24' alt='CD'>

							<span></span></button></a>&nbsp;";

    else:

        $n=@mysql_num_rows(mysql_query("select * from bsi_site_contents where parent_id=" . $d['id'] . " order by ord"));

	    if($n):  

		if(isset($tid)){

		$tid=$tid;

			}else{

				$tid='';

			}

			echo"<a href='" . $_SERVER['PHP_SELF'] . "?tid=". $tid . "|" . $d['id'] . "|'\"><button class='skin_colour round_all'><img src='images/icons/small/white/cd.png' width='24' height='24' alt='CD'><span></span></button></a>&nbsp;"; 

        else:

		    echo"<button class='skin_colour round_all'><img src='images/icons/small/white/cd.png' width='24' height='24' alt='CD'><span></span></button>&nbsp;"; 

		endif;

	endif;

	

	if($d['status']=='Y'){$stat1="Active";}else{$stat1="Hidden";}

	if(isset($_REQUEST['tid'])){

		$_REQUEST['tid']=$_REQUEST['tid'];

	}else{

		$_REQUEST['tid']='';

	}
	$menutype=($d['header_type'] =='1' && $d['footer_type'] =='1')? "Header & Footer" : (($d['header_type'] =='1' && $d['footer_type'] =='0')? "Header" : (($d['header_type'] =='0' && $d['footer_type'] =='1')? "Footer":""));

    echo"<a  href='page.editor.php?tid=" . $_REQUEST['tid']. "&id=" . $d['id'] . "' class='bodytext'>" . $d['cont_title'] . "</a></td>

	<td></td><td></td><td class='bodytext'>".$d['ord']."</td><td class='bodytext'>".$menutype."</td><td class='bodytext'>".$stat1."</td><td><a href='page.editor.php?tid=" . $_REQUEST['tid'] . "&id=" . $d['id'] . "'>Edit</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href='content.list.php?tid=" . $_REQUEST['tid'] . "&del=" . $d['id'] . "'>Delete</a></td></tr>";

    if(in_array($d['id'],$tids)):

		$rr=mysql_query("select * from bsi_site_contents where parent_id=" . $d['id'] . " order by ord");

		//echo"select * from delta_contents where parent_id=" . $d[id] . " order by ord";

		$k=0;

		while($dd=mysql_fetch_assoc($rr)):

	        if($dd['status']=='Y'){$stat2="Active";}else{$stat2="Hidden";}
			$menutype=($dd['header_type'] =='1' && $dd['footer_type'] =='1')? "Header & Footer" : (($dd['header_type'] =='1' && $dd['footer_type'] =='0')? "Header" : (($dd['header_type'] =='0' && $dd['footer_type'] =='1')? "Footer":""));

	        echo"<tr bgcolor=whitesmoke><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|___________________________</td><td><a  class='bodytext' href='page.editor.php?tid=" . $_REQUEST['tid'] . "&id=" . $dd['id'] . "'>" . $dd['cont_title'] . "</a></td><td></td><td class='bodytext'>".$dd['ord']."</td><td class='bodytext'>".$menutype."</td><td class='bodytext'>".$stat2."</td><td> <a class='bodytext' href='page.editor.php?tid=" . $_REQUEST['tid'] . "&id=" . $dd['id'] .  "'>Edit</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a class='bodytext' href='content.list.php?tid=" . $_REQUEST['tid'] . "&del=" . $dd['id'] . "'>Delete</a> </td></tr>";

		    $r3=mysql_query("select * from bsi_site_contents where parent_id=" . $dd['id'] . " order by ord");

			//echo"select * from delta_contents where parent_id=" . $dd[id] . " order by ord";

	        $k=0;

	        while($d3=mysql_fetch_assoc($r3)):

			if($d3['status']=='Y'){$stat3="Active";}else{$stat3="Hidden";}
              $menutype=($d3['header_type'] =='1' && $d3['footer_type'] =='1')? "Header & Footer" : (($d3['header_type'] =='1' && $d3['footer_type'] =='0')? "Header" : (($d3['header_type'] =='0' && $d3['footer_type'] =='1')? "Footer":""));

			    echo"<tr bgcolor=whitesmoke><td></td><td>|___________________________<td><a href='page.editor.php?tid=" . $_REQUEST['tid'] . "&id=" . $d3['id'] . "&parent_id=" . $dd['id'] . "' class='bodytext'>" . $d3['cont_title'] . "</td><td class='bodytext'>".$d3['ord']."</td><td class='bodytext'>".$menutype."</td><td class='bodytext'>".$stat3."</td><td> <a href='page.editor.php?tid=" . $_REQUEST['tid'] . "&id=" . $d3['id'] . "' class='bodytext'>Edit</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a class='bodytext' href='content.list.php?tid=" . $_REQUEST['tid'] . "&del=" . $d3['id'] . "'>Delete</a> </td></tr>";

		    endwhile;		

		    $k++;

        endwhile;

	endif;	

	$j++;

endwhile;   

?>
      </tbody>
    </table>
  </div>
  <?php 

					if(isset($_SESSION['msg_'])){

						echo $_SESSION['msg_'];

						unset($_SESSION['msg_']);

					}

					?>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>