<?php
class adminAjaxProcessor
{
	public function sendErrorMsg(){		
		$this->errorMsg = "unknown error";	
		echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
	}//end of function	
	
	
	
	
	
	public function getPricePlanFormGenerate(){
			/**
			 * Global Ref: conf.class.php
			 **/
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
			$result = mysql_query("select * from `bsi_roomtype` where hotel_id='".$hotelid."'");
			if(mysql_num_rows($result)){		
				$roomtype = '<option value="0">Select Room Type</option>';
				while($roomtypelRow=mysql_fetch_assoc($result)){
					$roomtype .="<option value=".$roomtypelRow['roomtype_id'].">".$roomtypelRow['type_name']."</option>";
				}
				$roomtype.="</select>";
				echo json_encode(array("errorcode"=>$errorcode,"roomtype_dowpdown"=>$roomtype));
			}else{
				$errorcode = 1;
				$strmsg = '<option value="0">No Roomtype available</option>';
				echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			}									
	}
	
	
	public function getCustomerEmailcontent(){
		       global $bsiCore;
		       $errorcode = 0;
		$strmsg = '<strong style="width:150px">Customer Email</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="cust_email" name="cust_email" style="width:250px;" class="required email"/>';
		
	echo json_encode(array("errorcode"=>$errorcode,"gethtml"=>$strmsg));	
	}
	
	public function getPricePlanForm(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid    = $bsiCore->ClearInput($_POST['hotelid']);
		$roomtypeId = $bsiCore->ClearInput($_POST['roomtypeId']);
		$currency_symbol= $bsiCore->currency_symbol();
		$sql1=mysql_query("select * from bsi_capacity where hotel_id='".$hotelid."'");
		if(mysql_num_rows($sql1)){	
			$gethtml="";
			while($row_capacity=mysql_fetch_assoc($sql1)){
				$result = mysql_query("select * from bsi_priceplan where hotel_id='".$hotelid."' and room_type_id='".$roomtypeId."' and 
								   capacity_id='".$row_capacity['capacity_id']."'");
				if(mysql_num_rows($result)){
					$row = mysql_fetch_assoc($result);
				 $gethtml.='<tr> 
								<td style="width:100px; padding:5px !important;">&nbsp;&nbsp;'.$row_capacity['title'].'</td> 									
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][sun]" id="priceplan['.$row_capacity['capacity_id'].'][sun]"  class="number"/> </td> 
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][mon]" id="priceplan['.$row_capacity['capacity_id'].'][mon]"  class="number"/> </td>  
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][tui]" id="priceplan['.$row_capacity['capacity_id'].'][tui]"  class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][wed]" id="priceplan['.$row_capacity['capacity_id'].'][wed]"  class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][thu]" id="priceplan['.$row_capacity['capacity_id'].'][thu]"  class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][fri]" id="priceplan['.$row_capacity['capacity_id'].'][fri]"  class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][sat]"  id="priceplan['.$row_capacity['capacity_id'].'][sat]"  class="number"/> </td>  </tr>';
/*<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][extrabed]"  id="priceplan['.$row_capacity['capacity_id'].'][extrabed]"  class="number"/> </td>  
								</tr>';*/
				}else{
					 $gethtml.='<tr> 
								<td style="width:100px; padding:5px !important;">&nbsp;&nbsp;'.$row_capacity['title'].'</td> 									
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"   style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][sun]" id="priceplan['.$row_capacity['capacity_id'].'][sun]" class="number"/> </td> 
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"   style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][mon]" id="priceplan['.$row_capacity['capacity_id'].'][mon]" class="number"/> </td>  
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][tui]" id="priceplan['.$row_capacity['capacity_id'].'][tui]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][wed]" id="priceplan['.$row_capacity['capacity_id'].'][wed]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan['.$row_capacity['capacity_id'].'][thu]" id="priceplan['.$row_capacity['capacity_id'].'][thu]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][fri]" id="priceplan['.$row_capacity['capacity_id'].'][fri]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][sat]"  id="priceplan['.$row_capacity['capacity_id'].'][sat]" class="number"/> </td> </tr>'; 
								 /*<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan['.$row_capacity['capacity_id'].'][extrabed]"  id="priceplan['.$row_capacity['capacity_id'].'][extrabed]" class="number"/> </td>  
								</tr> ';*/
				}
							//$gethtml.=	$row_capacity['title'];
					}
					    
					
					$gethtml.='<tr> 
								<td style="width:100px; padding:5px !important;">&nbsp;&nbsp;Per Child</td> 									
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"   style="width:70px;"  name="priceplan[1001][sun]" id="priceplan[1001][sun]" class="number"/> </td> 
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"   style="width:70px;" name="priceplan[1001][mon]" id="priceplan[1001][mon]" class="number"/> </td>  
								<td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan[1001][tui]" id="priceplan[1001][tui]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan[1001][wed]" id="priceplan[1001][wed]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;"  name="priceplan[1001][thu]" id="priceplan[1001][thu]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan[1001][fri]" id="priceplan[1001][fri]" class="number"/> </td>  
                                <td style="padding:5px !important;">'.$currency_symbol.'<input type="text"  style="width:70px;" name="priceplan[1001][sat]"  id="priceplan[1001][sat]" class="number"/> </td>  
								</tr> ';
					
					$gethtml.='<tr><td colspan="2"><font style="color:#F00;">* &nbsp;&nbsp;</font><b>This Field is required</b><br /><font style="color:#F00;">** &nbsp;</font><b>Only Numbers</b></td><td colspan="7">&nbsp;</td></tr>';
				echo json_encode(array("errorcode"=>$errorcode,"priceFrm"=>$gethtml));
			}else{
  
				$errorcode = 1;
				$strmsg = "Sorry! no Capacity found in this hotel!";
				echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			}
	}
	
	public function getPricePlanListGenerate(){
			global $bsiCore;
			$errorcode   = 0;
			$strmsg      = "";
			$hotelid     = $bsiCore->ClearInput($_POST['hotelid']);	
			$roomtype_id = $bsiCore->ClearInput($_POST['roomtype_id']);
			
			$currency_symbol= $bsiCore->currency_symbol();
			$daterange   = mysql_query("select date_start, date_end, DATE_FORMAT(date_start, '".$bsiCore->userDateFormat."') AS start_date1, DATE_FORMAT(date_end, '".$bsiCore->userDateFormat."') AS end_date1, `default` from bsi_priceplan where room_type_id='".$roomtype_id."' and hotel_id='$hotelid' group by date_start, date_end");
					
			if(mysql_num_rows($daterange)){	
				$gethtml = "";
				while($row_daterange = mysql_fetch_assoc($daterange)){
					//$query = mysql_query("select bp.*, bc.title from bsi_priceplan as bp, bsi_capacity as bc where date_start='".$row_daterange['date_start']."' and date_end='".$row_daterange['date_end']."' and room_type_id='".$roomtype_id."' and bp.capacity_id=bc.capacity_id");
					
					$query = mysql_query("select bp.* from bsi_priceplan as bp where date_start='".$row_daterange['date_start']."' and date_end='".$row_daterange['date_end']."' and room_type_id='".$roomtype_id."'");
					if($row_daterange['default'] == 1){  
						$gethtml .= '<tr class="gradeX"><td colspan="10"><strong>Regular Price</strong></td></tr>';
						$daletetd = mysql_num_rows($query);	
						$i1       = $daletetd;
						while($row_pp=mysql_fetch_assoc($query)){	
						
						
						
							if($row_pp['capacity_id']==1001){
							  $captitle='Per Child'; 
							  $gethtml.='<tr class="gradeX"> 
												<td>'.$captitle.'</td> 									 
												<td>'.$currency_symbol.$row_pp['sun'].'</td> 
												<td>'.$currency_symbol.$row_pp['mon'].'</td>  
												<td>'.$currency_symbol.$row_pp['tue'].'</td>  
												<td>'.$currency_symbol.$row_pp['wed'].'</td>  
												<td>'.$currency_symbol.$row_pp['thu'].'</td>  
												<td>'.$currency_symbol.$row_pp['fri'].'</td>  
												<td>'.$currency_symbol.$row_pp['sat'].'</td>
												
												';
						  }else{
							  $capacity_title=mysql_fetch_assoc(mysql_query("select * from bsi_capacity where capacity_id=".$row_pp['capacity_id']));
							  $captitle=$capacity_title['title'];
							  $gethtml.='<tr class="gradeX"> 
												<td>'.$captitle.'</td> 									 
												<td>'.$currency_symbol.$row_pp['sun'].'</td> 
												<td>'.$currency_symbol.$row_pp['mon'].'</td>  
												<td>'.$currency_symbol.$row_pp['tue'].'</td>  
												<td>'.$currency_symbol.$row_pp['wed'].'</td>  
												<td>'.$currency_symbol.$row_pp['thu'].'</td>  
												<td>'.$currency_symbol.$row_pp['fri'].'</td>  
												<td>'.$currency_symbol.$row_pp['sat'].'</td>';
												
												/*<td>'.$currency_symbol.$row_pp['extrabed'].'</td>';*/
						  }
							
												
												
							if($daletetd==$i1){	
								 $gethtml .= '<td rowspan="'.$daletetd.'"><a href="pricePlan.php?default_value='.base64_encode($row_pp['default']).'&rtype_id='.base64_encode($row_pp['room_type_id']).'&start_date='.base64_encode($row_pp['date_start']).'&end_date='.base64_encode($row_pp['date_end']).'&hid='.base64_encode($row_pp['hotel_id']).'">Edit</a></td>';
								 $gethtml .= '</tr>';
							}
							$i1--;
						}
					}else{
						$gethtml .= '<tr class="gradeX"><td colspan="9"><strong>Date Range : '.$row_daterange['start_date1'].'&nbsp; To &nbsp;'.$row_daterange['end_date1'].'</strong></td></tr>';
						$daletetd = mysql_num_rows($query);		
					    $i1       = $daletetd;
						while($row_pp=mysql_fetch_assoc($query)){
							
							if($row_pp['capacity_id']==1001){
							  $captitle='Per Child'; 
						  }else{
							  $capacity_title=mysql_fetch_assoc(mysql_query("select * from bsi_capacity where capacity_id=".$row_pp['capacity_id']));
							  $captitle=$capacity_title['title'];
						  }
							$gethtml.='<tr class="gradeX"> 
												<td>'.$captitle.'</td> 									 
												<td>'.$currency_symbol.$row_pp['sun'].'</td> 
												<td>'.$currency_symbol.$row_pp['mon'].'</td>  
												<td>'.$currency_symbol.$row_pp['tue'].'</td>  
												<td>'.$currency_symbol.$row_pp['wed'].'</td>  
												<td>'.$currency_symbol.$row_pp['thu'].'</td>  
												<td>'.$currency_symbol.$row_pp['fri'].'</td>  
												<td>'.$currency_symbol.$row_pp['sat'].'</td>';
												
												/*<td>'.$currency_symbol.$row_pp['extrabed'].'</td>';*/
							if($daletetd==$i1){
							    $pln_del = base64_encode($row_pp['date_start'].'|'.$row_pp['date_end'].'|'.$row_pp['room_type_id'].'|'.$row_pp['hotel_id']);
							    $gethtml .= '<td rowspan="'.$daletetd.'"><a href="pricePlan.php?rtype_id='.base64_encode($row_pp['room_type_id']).'&start_date='.base64_encode($row_pp['date_start']).'&end_date='.base64_encode($row_pp['date_end']).'&default_value='.base64_encode($row_pp['default']).'&hid='.base64_encode($row_pp['hotel_id']).'">Edit</a>&nbsp;&nbsp;';
							   $gethtml .= '<a href="javascript:;" onclick="javascript:priceplan_delete(\''.$pln_del.'\');">Delete</a></td>';
							   $gethtml .= '</tr>';
							}
					   	$i1--;
						}
					}
				}	
				$_SESSION['hotel_id']   = $hotelid;
				$_SESSION['roomtypeid'] = $roomtype_id;
				echo json_encode(array("errorcode" => $errorcode, "strhtml" => $gethtml));								
			}else{
				$errorcode = 1;
				$strmsg = "Sorry! no price plan found in this Room Type!";
				echo json_encode(array("errorcode" => $errorcode, "strmsg" => $strmsg));	
			}
			
	}
	
	public function getRooTypeListGenerate(){
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			$roomtype='<option value="0" selected="selected">Select Room Type</option>';
			$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
			$result = mysql_query("select * from `bsi_roomtype` where hotel_id='".$hotelid."'") or die("Error at line : 103".mysql_error());
			if(mysql_num_rows($result)){
				while($roomtypelRow=mysql_fetch_assoc($result)){
					
						$roomtype .="<option value=".$roomtypelRow['roomtype_id'].">".$roomtypelRow['type_name']."</option>";
					
				}
				//$_SESSION['hotel_id'] = $hotelid;
				//$_SESSION['roomtypeid'] = 
				echo json_encode(array("errorcode"=>$errorcode,"roomtype_dowpdown"=>$roomtype));
			}
	}
	
	public function submitPricePlanForm(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
		$pricedata = $_POST['pricedata'];
		
		/*$arr1=array_keys($pricedata);
		for($i=0;$i<count($arr1);$i++) {
			$arr2=array_values($pricedata[$arr1[$i]]);
			$capacity_id=$arr1[$i];
			$qry="INSERT INTO `bsim`.`bsi_priceplan` (hotel_id, capaity_id, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`) VALUES ($hotelid, $capacity_id,'$arr2[0]', '$arr2[1]', '$arr2[2]', '$arr2[3]', '$arr2[4]', '$arr2[5]','$arr2[6]',)";
			//mysql_query($qry) or die("not executed".mysql_error());
		}*/
		$gethtml= $pricedata;
		//$gethtml='<tr><td colspan="8">Price sucessfully inserted!</td></tr>';
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));	
	}
	//************************************************************8
	public function getCategoryListGenerate(){
			global $bsiCore;   
			$errorcode = 0;
			$strmsg = "";
			$hotelid = $bsiCore->ClearInput($_POST['hotelid']);			
			$sql1=mysql_query("select * from bsi_around_hotel_category where hotel_id=".$hotelid);
			if(mysql_num_rows($sql1))
			{	
				
				$gethtml="";
				while($row_category=mysql_fetch_assoc($sql1)){
				$gethtml.='<tr class="gradeX"><td>'.$row_category['category_title'].'</td><td><a href="add_edit_Category.php?edit=333&category_id='.$row_category['category_id'].'">Edit</a></td><td><a href="add_edit_Category.php?delete=555&category_id='.$row_category['category_id'].'">Delete</a></td></tr> ';
			}		
				echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));								
			}else{
				$errorcode = 1;
				$strmsg = "Sorry! no Category found in this hotel!";
				echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			}
	}
	
	public function getRoomListGenerate(){
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			$hotelid = $bsiCore->ClearInput($_POST['hotelid']);			
			$sql1=mysql_query("select br.*, brt.type_name, bc.capacity, bc.title, count(*) from bsi_room br, bsi_roomtype brt, bsi_capacity bc where br.roomtype_id=brt.roomtype_id and br.capacity_id=bc.capacity_id and br.hotel_id=".$hotelid." group by `roomtype_id`,`capacity_id`, `no_of_child`");
			if(mysql_num_rows($sql1))
			{	$i=1;
				$gethtml="";
				while($row_room=mysql_fetch_assoc($sql1)){
                 $extrabed = ($row_room['extra_bed'] == true) ? 'Yes' : 'No';
				$gethtml.='<tr class="gradeX">
				<td>'.$row_room['type_name'].'</td>
				<td>'.$row_room['title'].'('.$row_room['capacity'].')</td>
				<td>'.$row_room['count(*)'].'</td>
               
				<td>'.$row_room['no_of_child'].'</td>
				<td align="right"><a href="roomList.php?delid=555&roomtype_id='.base64_encode($row_room['roomtype_id']).'&capacity_id='.base64_encode($row_room['capacity_id']).'&no_of_child='.base64_encode($row_room['no_of_child']).'&hotel_id='.base64_encode($row_room['hotel_id']).'">Delete</a></td>
				</tr>';
				$i++;
				}	
			//$gethtml="aaaaaaaaaaaaaaaa";
				echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));								
			}else{
				$errorcode = 1;
				$strmsg = "Sorry! no Room Category found in this hotel!";
				echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			}
	}
	
	public function getRoomTypeandCapacityListGenerate()
	{
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
		
		$sqlRoomType=mysql_query("select * from `bsi_roomtype` where hotel_id=".$hotelid);
		if(mysql_num_rows($sqlRoomType)){
			//$getroomtype = "aaaaaaaaaaaaaaaaaaa";
			$getroomtype = '<select name="roomtype_id" id="roomtype_id"><option value="0">Select Room Type</option>';
			while($rowroomtype=mysql_fetch_assoc($sqlRoomType)){
				$getroomtype .= "<option value=".$rowroomtype['roomtype_id'].">".$rowroomtype['type_name']."</option>";	
			}
			$getroomtype .= "</select>";
			
			$sqlcapacity=mysql_query("select * from `bsi_capacity` where hotel_id=".$hotelid);
			$getcapacity = '<select name="capacity_id" id="capacity_id"><option value="0">Select Capacity</option>';
			while($rowcapacity=mysql_fetch_assoc($sqlcapacity)){
				$getcapacity .= "<option value=".$rowcapacity['capacity_id'].">".$rowcapacity['title']."(".$rowcapacity['capacity'].")</option>";	
			}
			$getcapacity .= "</select>";
			
			echo json_encode(array("errorcode"=>$errorcode,"roomtype"=>$getroomtype, "capacity"=>$getcapacity));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Room Type and Capacity found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"roomtype"=>$strmsg,"capacity"=>$strmsg));
		}
	}
	
	public function getRoomTypeListGenerate(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);		
		$sqllist = mysql_query("select * from bsi_roomtype where `hotel_id`=".$hotelid);
		if(mysql_num_rows($sqllist)){
			$getRoomTypeList = "";
			while($rowRoomType=mysql_fetch_assoc($sqllist)){
				$getRoomTypeList .='<tr class="gradeX"><td>'.$rowRoomType['type_name'].'</td><td>'.$rowRoomType['services'].'</td><td align="right" style="padding-right:15px;"><a href="hotel_room_type.php?roomtype_id='.base64_encode($rowRoomType['roomtype_id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:roomtype_delete('.$rowRoomType['roomtype_id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"roomTypelist"=>$getRoomTypeList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Room Type List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function getCapacityListGenerate(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
		$sqlcategory = mysql_query("select * from bsi_capacity where `hotel_id`=".$hotelid);
		if(mysql_num_rows($sqlcategory)){			
			$getCategoryList = "";
			while($rowCategoryList=mysql_fetch_assoc($sqlcategory)){
				$getCategoryList .='<tr class="gradeX"><td>'.$rowCategoryList['title'].'</td><td>'.$rowCategoryList['capacity'].'</td><td  align="right" style="padding:0 15px; 0 0;"><a href="add_edit_Capacity.php?id='.base64_encode($rowCategoryList['capacity_id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:capacity_delete('.$rowCategoryList['capacity_id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"categoryList"=>$getCategoryList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Capacity List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	
	public function getAroundListGenerate(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$sqlaround = mysql_query("select * from `bsi_around_hotel_category` where `hotel_id`='".$hotelid."'");
		if(mysql_num_rows($sqlaround)){
			$getAroundList = "";
			while($rowAround=mysql_fetch_assoc($sqlaround)){
				$getAroundList .='<tr class="gradeX"><td style="padding-left:10px;"><label>'.$rowAround['category_title'].'</label></td><td align="right" style="padding-right:15px;"><a href="add_edit_Category.php?category_id='.base64_encode($rowAround['category_id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:capacity_delete('.$rowAround['category_id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"aroundList"=>$getAroundList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Around Category List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function getCategoryAroundListGenerate(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$sqlaround = mysql_query("SELECT bah . * , bahc.category_title FROM `bsi_around_hotel` bah, `bsi_around_hotel_category` bahc WHERE bah.category_id = bahc.category_id AND bah.hotel_id = bahc.hotel_id AND bah.hotel_id ='".$hotelid."'");
		if(mysql_num_rows($sqlaround)){
			$getAroundList = "";
			while($rowAround=mysql_fetch_assoc($sqlaround)){
				$getAroundList .='<tr class="gradeX"><td>'.$rowAround['category_title'].'</td><td>'.$rowAround['title'].'</td><td>'.$rowAround['distance'].'</td><td align="right" style="padding-right:15px;"><a href="addedit_around_category.php?id='.base64_encode($rowAround['id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:capacity_delete('.$rowAround['id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"aroundList"=>$getAroundList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Around Category List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function getCategoryGenerate(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$sqlaround = mysql_query("SELECT * from bsi_around_hotel_category where hotel_id='".$hotelid."'");
		if(mysql_num_rows($sqlaround)){			
			//$getAroundList = "qqqqqqqqqqqqqqqqqqqq";
			$getcategoryList = '<select name="category_title" id="category_title"><option value="0">select category</option>';
			while($rowAround=mysql_fetch_assoc($sqlaround)){
				$getcategoryList .='<option value="'.$rowAround['category_id'].'">'.$rowAround['category_title'].'</option>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"categoryList"=>$getcategoryList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Category List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		} 
	}
	
	//hotelidtype photogenerate
	public function getHotelidtypephoto(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$getphoto=mysql_query("SELECT * from bsi_gallery where hotel_id=".$hotelid);
		
		if(mysql_num_rows($getphoto)){
			$getphotolist='<div class="indent gallery">
								<ul class="clearfix">';				
			$i=1;
			while($photorow=mysql_fetch_assoc($getphoto)){
				$getphotolist.='<li data-id="bl01" data-type="blue" style="width:168px;">
										<a rel="collection" href="../gallery/hotelImage/'.$photorow['img_path'].'">
										<img src="../gallery/hotelImage/thumb_'.$photorow['img_path'].'" width="150px" height="125px"/></a>
										<span class="name"><div><button id="'.$photorow['id'].'" onclick="return delFunction(this.id, '.$hotelid.');" class="skin_colour round_all"><img src="images/icons/small/white/cut_scissors.png" width="23" height="23" alt="cut scissors"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></button></div></span></li>';
				$i++;	
			}
			
			$getphotolist.='</ul>
						 </div><script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
						<script type="text/javascript">	
							//FancyBox Config (more info can be found at http://www.fancybox.net/)
								$(".gallery ul li a").fancybox({
									\'overlayColor\':\'#000\' 		
								});
								$("a img.fancy").fancybox();
						</script>';	 
						
			echo json_encode(array("errorcode"=>$errorcode,"categoryphoto"=>$getphotolist));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Category Photo found for this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
		
	}
	
	public function getHotelidphoto(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$getphoto=mysql_query("SELECT * from bsi_gallery where hotel_id=".$hotelid);
		
		if(mysql_num_rows($getphoto)){
			$getphotolist='<div class="indent gallery">
								<ul class="clearfix">';				
			$i=1;
			while($photorow=mysql_fetch_assoc($getphoto)){
				$getphotolist.='<li data-id="bl01" data-type="blue" style="width:168px;">
										<a rel="collection" href="../gallery/hotelImage/'.$photorow['img_path'].'">
										<img src="../gallery/hotelImage/thumb_'.$photorow['img_path'].'" width="150px" height="125px"/></a>
										<span class="name"><div><button id="'.$photorow['id'].'" onclick="return delFunction(this.id, '.$hotelid.');" class="skin_colour round_all"><img src="../admin/images/icons/small/white/cut_scissors.png" width="23" height="23" alt="cut scissors"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></button></div></span></li>';
				$i++;	
			}
			
			$getphotolist.='</ul>
						 </div><script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
						<script type="text/javascript" src="../admin/js/fancybox/jquery.fancybox-1.3.4.js"></script>
						<script type="text/javascript">	
							//FancyBox Config (more info can be found at http://www.fancybox.net/)
								$(".gallery ul li a").fancybox({
									\'overlayColor\':\'#000\' 		
								});
								$("a img.fancy").fancybox();
						</script>';
						echo json_encode(array("errorcode"=>$errorcode,"categoryphoto"=>$getphotolist));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Category Photo found for this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
		
	}
	//get view_booking details
	public function getViewBooking(){
	    global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
	    $bookinglisttype=$bsiCore->ClearInput($_POST['booking_list_type']);
		$getViewbookinglist='';
		if($bookinglisttype == 0){			
				$view_booking_result=mysql_query("select DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date,DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date,DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time, bb.booking_id,bc.first_name,bc.surname,bc.phone,bb.total_cost
			from bsi_bookings as bb,bsi_clients as bc 
			where bb.client_id=bc.client_id and
			bb.hotel_id='".$hotelid."' and 
			(checkout_date < curdate() OR bb.is_deleted=1)");
			while($getViewbookingrow=mysql_fetch_assoc($view_booking_result)){
				$getViewbookinglist.='<tr>';
				$getViewbookinglist.='<td>'.$getViewbookingrow['booking_id'].'</td>
				<td nowrap="nowrap">'.$getViewbookingrow['first_name'].' '.$getViewbookingrow['surname'].'</td>
				<td>'.$getViewbookingrow['phone'].'</td>
				<td>'.$getViewbookingrow['checkin_date'].'</td>
				<td>'.$getViewbookingrow['checkout_date'].'</td>
				<td>'.$bsiCore->config['conf_currency_symbol'].$getViewbookingrow['total_cost'].'</td>
				<td>'.$getViewbookingrow['booking_time'].'</td>
				<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap">
					<a href="viewdetails.php?booking_id='.base64_encode($getViewbookingrow['booking_id']).'">View Details</a> | 
					<a href="javascript:;" onclick="return cancel(\''.$getViewbookingrow['booking_id'].'\');">Delete</a> | 
					<a href="javascript:;" onclick="printinvoice(\''.$getViewbookingrow['booking_id'].'\');">Print Voucher</a>
				</td>';
			
		$getViewbookinglist.='</tr>';
		}	
		}else{
			$view_booking_result=mysql_query("select DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date,DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date,bb.payment_type, bb.booking_id,bc.first_name,bc.surname,bc.phone,bb.total_cost
			from bsi_bookings as bb,bsi_clients as bc 
			where bb.client_id=bc.client_id and
			bb.hotel_id='".$hotelid."' and 
			(checkout_date > curdate() and bb.is_deleted=0)");
	while($getViewbookingrow=mysql_fetch_assoc($view_booking_result))
		{
			
			$getViewbookinglist.='<tr>';
			$getViewbookinglist.='<td>'.$getViewbookingrow['booking_id'].'</td>'.'<td nowrap="nowrap">'.$getViewbookingrow['first_name'].' '.$getViewbookingrow['surname'].'</td>'.'<td>'.$getViewbookingrow['phone'].'</td>'.'<td>'.$getViewbookingrow['checkin_date'].'</td>'.'<td>'.$getViewbookingrow['checkout_date'].'</td>'.'<td>'.$bsiCore->config['conf_currency_symbol'].$getViewbookingrow['total_cost'].'</td>'.'<td>'.$bsiCore->paymentGateway($getViewbookingrow['payment_type']).'</td>'.'<td style="text-align:right; padding:0px 6px 0px 0px" nowrap="nowrap"><a href="viewdetails.php?booking_id='.base64_encode($getViewbookingrow['booking_id']).'">'.'View Details'.'</a> | <a href="javascript:;" onclick="return cancel(\''.$getViewbookingrow['booking_id'].'\');">'.'Cancel'.'</a> | <a href="javascript:;" onclick="printinvoice(\''.$getViewbookingrow['booking_id'].'\');">'.'Print Voucher'.'</td></a>';
			
		$getViewbookinglist.='</tr>';
		}	
	}
		
		
		if(mysql_num_rows($view_booking_result)){		
		
		echo  json_encode(array("errorcode"=>$errorcode,"viewbookingresult"=>$getViewbookinglist));		
	}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Viewbooking result found for this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	//getdiscount
	public function getDiscounts()
	{
	    //global $bsiCore;
		$errorcode = 0;
		//$chk_discount =$_POST['chk_discount']; 
		$getddresult="";
		$type=$_POST['type'];
		$deposit_discount_result=mysql_query("SELECT * FROM bsi_deposit_discount");
		
		switch($type){
			case  1:
			     $chk_discount =$_POST['chk_discount']; 
				 if($chk_discount=='true' ){
					
					 while($getrowresult=mysql_fetch_assoc($deposit_discount_result)){
						 	$getddresult.='<tr><th  align="left">'.$getrowresult['month'].'</th><td><input type="text" name="'.$getrowresult['month_num'].'" value="'.$getrowresult['discount_percent'].'" style="width:70px;" />%</td></tr>'; 
					 }
					
					$getddresult.='<tr><td></td><td><button name="act_sbmt" class="button_colour round_all" value="submit" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button></td></tr>';
mysql_query("update bsi_configure set conf_value='1' where conf_key='conf_enabled_discount'");
				 }else{
					 mysql_query("update bsi_configure set conf_value='0' where conf_key='conf_enabled_discount'");
					 $getddresult='<tr><td colspan="2">Discount feature is disabled!</td></tr>';
				 }
				
			break;
			
			case 2:
			    $chk_deposit =$_POST['chk_deposit'];	
				if($chk_deposit=='true' ){
					 while($getrowresult=mysql_fetch_assoc($deposit_discount_result)){
						 	$getddresult.='<tr><th align="left">'.$getrowresult['month'].'</th><td><input type="text" name="'.$getrowresult['month_num'].'" value="'.$getrowresult['deposit_percent'].'" style="width:70px;"/>%</td></tr>';
					 }
					$getddresult.='<tr><td></td><td><button name="act_save" class="button_colour round_all" value="submit" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button></td></tr>';
mysql_query("update bsi_configure set conf_value='1' where conf_key='conf_enabled_deposit'");					 
				 }else{
					     mysql_query("update bsi_configure set conf_value='0' where conf_key='conf_enabled_deposit'");
					 	$getddresult.='<tr><td colspan="2">Deposit feature is disabled!</td></tr>';
				 }
				 
			break;
			
		}  
	
									
	 echo  json_encode(array("errorcode"=>$errorcode,"getresult"=>$getddresult)); 
	
	
	}
	
	public function getbsiEmailcontent(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$getArray = array();
		
		$choiceid = $bsiCore->ClearInput($_POST['choiceid']);
		$result = mysql_query("select * from bsi_email_contents where id='".$choiceid."'");
		
		if(mysql_num_rows($result)){
			$getEmailcontentlist=mysql_fetch_assoc($result);
			$email = $getEmailcontentlist['email_subject'];
			$emailText = $getEmailcontentlist['email_text'];
			$getArray['email'] = $email;
			$getArray['emailText'] = $emailText;
			echo json_encode(array("errorcode"=>$errorcode,"viewcontent"=>$getArray['email'],"viewcontent1"=>$choiceid, "viewcontent2"=>$getArray['emailText']));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no  result found ";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	public function getbsiClientinfo()
	{
					global $bsiCore;
					$errorcode = 0;
					$strmsg = "";
					$inputtext = $bsiCore->ClearInput($_POST['searchtext']);
					$clientresult=mysql_query("SELECT bc.*,bco.name FROM bsi_clients as bc,bsi_country as bco WHERE  bco.country_code=bc.country   and CONCAT(title,first_name,surname) LIKE '%".$inputtext."%'");
					if(mysql_num_rows($clientresult))
					{
					$getclientlist='';
					while($clientrow=mysql_fetch_assoc($clientresult))	
					{
						$getclientlist.='<tr>';
						$getclientlist.='<td><label>'.$clientrow['title']." ".$clientrow['first_name']." ".$clientrow['surname'].'</label></td><td><label>'.$clientrow['street_addr'].'</label></td>'.'<td><label>'.$clientrow['city'].'</label></td>'.'<td><label>'.$clientrow['province'].'</label></td>'.'<td><label>'.$clientrow['zip'].'</label></td>'.'<td><label>'.$clientrow['name'].'</label></td>'.'<td><label>'.$clientrow['phone'].'</label></td>'.'<td><label>'.$clientrow['email'].'</label></td>';
			
		$getclientlist.='</tr>';
					}
						echo json_encode(array("errorcode"=>$errorcode,"viewcontent"=>$getclientlist));
					}
					else{
						$errorcode = 1;
			$strmsg = "Sorry! no  result found ";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
					}
					
	}
	//getbsiPromocode
	public function getbsiPromoCode()
	{
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "succesfully inserted";
		//$couponinfo = $bsiCore->ClearInput($_POST['frm_submit']);
		$coupon_code=$bsiCore->ClearInput($_POST['coupon_code']);
		$discount_amt=$bsiCore->ClearInput($_POST['discount_amt']);
		$min_amt=$bsiCore->ClearInput($_POST['min_amt']);
		$exp_date=$bsiCore->ClearInput($_POST['exp-date']);
		$coupon_category=$bsiCore->ClearInput($_POST['coupon_category']);
		$cust_email=$bsiCore->ClearInput($_POST['cust_email']);
		$rad_discount_type=$bsiCore->ClearInput($_POST['rad_discount_type']);
		$chk_reusecoupon=$bsiCore->ClearInput($_POST['chk_reusecoupon']);
		
		if($cust_email != "undefined"){
			$email = $cust_email;
		}else{
			$email = "";
		}
		
		$bsipromocoderesult=mysql_query("insert into  `bsi_promocode`(`promo_code`,`discount`,`min_amount`,`percentage`,`promo_category`,`customer_email`,`exp_date`,`reuse_promo`)values('".$coupon_code."','".$discount_amt."','".$min_amt."','".$rad_discount_type."','".$coupon_category."','".$email."','".$exp_date."','".$chk_reusecoupon."')");
//mysql_query("select * from ")					
	echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));				
	}
	public function getDiscountData(){
		 global $bsiCore;
		 $errorcode = 0;
		 $strmsg = "succesfully inserted";
		 $getHtml="";
		 $result=mysql_query("select promo_id,promo_code,discount,min_amount,percentage,promo_category,customer_email,reuse_promo,DATE_FORMAT(exp_date,'".$bsiCore->userDateFormat."') AS exp_date from bsi_promocode");
		 if(mysql_num_rows($result)){
				
			while($row=mysql_fetch_assoc($result)){
				$promoid=$row['promo_id'];
				$amount='';	
				
				if($row['percentage']==1)
				{
					$amount.=$row['discount'].'%';
				}else{
					$amount.='$'.$row['discount'];
				}
					$getHtml.='<tr>
								<td>'.$row['promo_code'].'</td>
								<td>'.$amount.'</td>
								<td>'.$bsiCore->config['conf_currency_symbol'].$row['min_amount'].'</td>
								<td>'.$row['exp_date'].'</td>
								<td>'.$row['customer_email'].'</td>
								<td>'.$row['reuse_promo'].'</td><td style="float:right"><a href="discount_coupon.php?id='.$promoid.'">'."Delete".'</a></td></tr>';
								
			}
			$getHtml=$getHtml;
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$getHtml));	
		}
		
	}
	//searchResultByBookingId
public function searchResultByBookingId(){
					global $bsiCore;
					$errorcode = 0;
					$getHTML = "";
					$searchid = $bsiCore->ClearInput($_POST['searchid']);
					$id = $bsiCore->ClearInput($_POST['id']);
	                 $searchresult=mysql_fetch_assoc(mysql_query("select  DATE_FORMAT(bb.checkin_date,'".$bsiCore->userDateFormat."') AS checkin_date, DATE_FORMAT(bb.checkout_date,'".$bsiCore->userDateFormat."') AS checkout_date,DATE_FORMAT(bb.booking_time,'".$bsiCore->userDateFormat."') AS booking_time,bb.booking_id,bc.first_name,bc.surname,bc.phone,bb.total_cost,bb.payment_type 
from bsi_bookings as bb,bsi_clients as bc 
where bb.client_id=bc.client_id and bb.booking_id='".$searchid."'"));
					 
					 if($id == 1){
					$getHTML.='<tr><td>'.$searchresult['booking_id'].'</td><td>'.$searchresult['first_name'].' '.$searchresult['surname'].'</td><td>'.$searchresult['phone'].'</td><td>'.$searchresult['checkin_date'].'</td><td>'.$searchresult['checkout_date'].'</td><td>'.$bsiCore->config['conf_currency_symbol'].$searchresult['total_cost'].'</td><td>'.$searchresult['booking_time'].'</td><td style="text-align:right; padding:0px 6px 0px 0px"><a href="viewdetails.php?booking_id='.base64_encode($searchresult['booking_id']).'">'."View Details".'</a> | <a href="javascript:;" onclick="return cancel(\''.$searchresult['booking_id'].'\');">'."Cancel".'</a> | <a href="javascript:;" onclick="printinvoice(\''.$searchresult['booking_id'].'\');">'."Print Invoice".'</a></td></tr>';
					 }else{
						 $getHTML.='<tr><td>'.$searchresult['booking_id'].'</td><td>'.$searchresult['first_name'].' '.$searchresult['surname'].'</td><td>'.$searchresult['phone'].'</td><td>'.$searchresult['checkin_date'].'</td><td>'.$searchresult['checkout_date'].'</td><td>'.$bsiCore->config['conf_currency_symbol'].$searchresult['total_cost'].'</td><td>'.$bsiCore->paymentGateway($searchresult['payment_type']).'</td><td style="text-align:right; padding:0px 6px 0px 0px"><a href="viewdetails.php?booking_id='.base64_encode($searchresult['booking_id']).'">'."View Details".'</a> | <a href="javascript:;" onclick="return cancel(\''.$searchresult['booking_id'].'\');">'."Cancel".'</a> | <a href="javascript:;" onclick="printinvoice(\''.$searchresult['booking_id'].'\');">'."Print Invoice".'</a></td></tr>';
					 }
 echo json_encode(array("errorcode"=>$errorcode,"getresult"=>$getHTML));    
  }
  
  	public function getHotelFacility(){ 
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);
		$sqlaround = mysql_query("SELECT * FROM `bsi_hotel_facilities` WHERE hotel_id ='".$hotelid."'");
		if(mysql_num_rows($sqlaround)){
			$getAroundList = "";
			while($rowAround=mysql_fetch_assoc($sqlaround)){
				$getAroundList .='<tr class="gradeX"><td valign="top">'.$rowAround['general'].'</td><td  valign="top">'.$rowAround['activities'].'</td><td valign="top">'.$rowAround['services'].'</td><td align="right" style="padding-right:15px;" valign="top"><a href="hotel_facility_entry.php?id='.base64_encode($rowAround['facilities_id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:capacity_delete('.$rowAround['facilities_id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"aroundList"=>$getAroundList));
		}else{
			$errorcode = 1;
			$strmsg = "Sorry! no Around Category List found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function getRoomCapacity(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$array=array();
		$room=$bsiCore->ClearInput($_POST['room']);
		$adult=$bsiCore->ClearInput($_POST['adult']);
		$a=$adult%$room;
			if($a==0){
				$perroom=$adult/$room;
				for($i=0; $i < $room; $i++){
				$array[]=$perroom;
				}
			//return $perroom;
			}else{
				$c=0;
				$d= $room-1;
				//$j=floor($adult/$room);
				for($i=0; $i < $d; $i++){
				$array[]=floor($adult/$room);
				$c=$c+floor($adult/$room);
				}
				$array[]=$adult-$c;
			}
			$adultperrrom="";
			$getArray='
			<table width="100%" style="border:solid 1px #801f31;">';
		  foreach($array as $i => $value){
			  $getArray.="<tr><td width='47%'><table width='100%'><tr><td><b>Room</b></td><td align='right'>".($i+1)."</td></tr></table></td><td width='5%'> &nbsp;: </td><td width='48%'><table width='100%'><tr><td>".$value."</td><td align='right'><b>Adult</b></td></tr></table></td></tr>";
			  $adultperrrom.=$value.'#'; 
		  }
		  $adultperrrom = substr($adultperrrom, 0, -1);
		  $_SESSION['adultperrrom']=$adultperrrom;
		  $getArray.='</table>';
		  echo json_encode(array("errorcode"=>$errorcode,"searchCapacity"=>$getArray));
	}
	
	public function getCommissiontable(){  
		global $bsiCore;
		$errorcode  = 0;
		$strmsg     = "";
		$i          = 1;
		$getHtml    = '<div class="box grid_16 round_all">
						  <table class="display datatable">
							<thead>
								  <tr>
									<th width="10%" nowrap>Booking ID</th>
									<th width="20%" nowrap>Hotel Name</th>
									<th width="10%" nowrap>Check In</th>
									<th width="10%" nowrap>Check Out</th>
									<th width="10%" nowrap>Amount</th>
									<th width="10%" nowrap>Booking Date</th>
									<th width="10%" nowrap>Commission</th>
									<th width="20%" nowrap>&nbsp;</th>
								   </tr>
							  </thead> 
							<tbody>';
		$agent_id   = $bsiCore->ClearInput($_POST['agent_id']);
		$sqlaround  = mysql_query("select bb.booking_id, bh.hotel_name, bc.first_name, bc.surname, DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') as booking_time, DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date, DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date, bb.payment_amount, bpg.gateway_name, bb.commission from bsi_bookings bb, bsi_hotels bh, bsi_clients bc, bsi_payment_gateway bpg where bb.agent=true and bb.payment_success=true and bb.hotel_id=bh.hotel_id and bb.client_id=bc.client_id and bb.payment_type=bpg.gateway_code and bb.agent_id=$agent_id");
		if(mysql_num_rows($sqlaround)){
			while($row = mysql_fetch_assoc($sqlaround)){
				$getHtml .= '<tr>
								<td nowrap>'.$row['booking_id'].'</td>
								<td nowrap align="center">'.$row['hotel_name'].'</td>
								<td nowrap>'.$row['checkin_date'].'</td>
								<td nowrap>'.$row['checkout_date'].'</td>
								<td nowrap align="center">'.$bsiCore->config['conf_currency_symbol'].$row['payment_amount'].'</td>
								<td nowrap>'.$row['booking_time'].'</td>
								<td nowrap align="center">'.$bsiCore->config['conf_currency_symbol'].$row['commission'].'</td>
								<td nowrap align="right"><a href="viewdetails.php?booking_id='.base64_encode($row['booking_id']).'">View Details</a></td>
							</tr>';
				$i++;			 
			}
			$getHtml .= '</tbody>
						  </table>
						</div>
						</div>
						<div style="padding-right:8px;">';
			$getHtml .=    '</div>
							</div>
							</div>
							</div>
							<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
							<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>';
			echo json_encode(array("errorcode"=>$errorcode,"table"=>$getHtml));
		}else{
			$errorcode = 1;
			$strmsg = '<div class="box grid_16 round_all">
						  <table class="display datatable">
							<thead>
							  <tr>
								<th width="10%" nowrap>Booking ID</th>
								<th width="20%" nowrap>Name</th>
								<th width="10%" nowrap>Check In</th>
								<th width="10%" nowrap>Check Out</th>
								<th width="10%" nowrap>Amount</th>
								<th width="10%" nowrap>Booking Date</th>
								<th width="10%" nowrap>Commission</th>
								<th width="20%" nowrap>&nbsp;</th>
							   </tr>
						  </thead>
							<tbody>
							</tbody>
						  </table>
						</div>
						</div>
						<div style="padding-right:8px;">
						</div>
						</div>
						</div>
						</div>
						<!--<div id="loading_overlay">
						  <div class="loading_message round_bottom">Loading...</div>
						</div>-->
						<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
						<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>';
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function chekEmail(){
	  global $bsiCore;
	  $errorcode  = 0;
	  $strmsg     = "";
	  $emailid    = mysql_real_escape_string($_POST['email']);
	  $sqlcheck   =mysql_query("select * from bsi_hotels where email_addr='".$emailid."'");
	  if(mysql_num_rows($sqlcheck)){
		  $strmsg     = '<font style="color:#F00;">Email Id Already Exist, Please Enter Another Email Id.</font>';
		  echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
	  }else{
		  $errorcode  = 1;
		  $strmsg     = '<font color="#009900">Valid Email</font>';
		  echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
	  }
	}
	
	
	public function generatecitydrop(){
		    global $bsiCore;
	        $errorcode  = 0;
			$country_code=mysql_real_escape_string($_POST['country_code']);
			$cname=mysql_real_escape_string($_POST['cname']);
			$gethtml885='<select name="city_name" id="city_name">';
		    $cres=mysql_query("select * from bsi_city where country_code='".$country_code."'");
			if(mysql_num_rows($cres)){
				//$gethtml885.='<option value="none">Select City</option>';
			 while($row77=mysql_fetch_assoc($cres)){
				 if($cname == $row77['city_name']){
				    $gethtml885.= '<option value="'.$row77['city_name'].'" selected="selected">'.$row77['city_name'].'</option>';
				 }else{
					  $gethtml885.= '<option value="'.$row77['city_name'].'">'.$row77['city_name'].'</option>';
				 }
			 }
		 }
		 $gethtml885.='</select>';
		 
		 echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$gethtml885));
	}
	
	
	public function getdiscountupdate(){
			/**
			 * Global Ref: conf.class.php
			 **/
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";	
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_january'])."' where month_num=1");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_february'])."' where month_num=2");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_march'])."' where month_num=3");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_april'])."' where month_num=4");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_may'])."' where month_num=5");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_june'])."' where month_num=6");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_july'])."' where month_num=7");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_august'])."' where month_num=8");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_september'])."' where month_num=9");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_october'])."' where month_num=10");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_november'])."' where month_num=11");
			mysql_query("update bsi_deposit_discount set discount_percent='".mysql_real_escape_string($_POST['discount_december'])."' where month_num=12");	
			$strmsg = '<span style="color:#006600; font-weight:bold;">Discount value updated!</span>';
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
	}
	
	
	public function getdepositupdate(){
			/**
			 * Global Ref: conf.class.php
			 **/
			 global $bsiCore;
			$errorcode = 0;
			$strmsg = "";	
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_january'])."' where month_num=1");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_february'])."' where month_num=2");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_march'])."' where month_num=3");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_april'])."' where month_num=4");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_may'])."' where month_num=5");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_june'])."' where month_num=6");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_july'])."' where month_num=7");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_august'])."' where month_num=8");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_september'])."' where month_num=9");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_october'])."' where month_num=10");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_november'])."' where month_num=11");
			mysql_query("update bsi_deposit_discount set deposit_percent='".mysql_real_escape_string($_POST['deposit_december'])."' where month_num=12");
			
			$strmsg = '<span style="color:#006600; font-weight:bold;">Deposit value updated!</span>';
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			
	}
	
	
	
	public function getExtrabed(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		
		$hotel_id = $bsiCore->ClearInput($_POST['hotelid']);
		$roomtype_id = $bsiCore->ClearInput($_POST['roomtype_id']);	
		$roomcapid   = $bsiCore->ClearInput($_POST['capacity_id']);
		// echo "select extrabed from bsi_priceplan where `default`=true and room_type_id=".$roomtype_id."   and  hotel_id=".$hotel_id." and capacity_id=".$roomcapid;die;
		$row_pp = mysql_fetch_assoc(mysql_query("select extrabed from bsi_priceplan where `default`=true and room_type_id=".$roomtype_id."   and  hotel_id=".$hotel_id." and capacity_id=".$roomcapid ));		
		if($row_pp['extrabed']=='0.00'){                    
			$extrabed_input_box='<span style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">NA(for active enter price in room type)</span>';
		}else{
			$extrabed_input_box='<input type="checkbox" name="extrabed" />';
		}
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$extrabed_input_box));		
	}
	
	
	public function getExtras(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
		$sqlcategory = mysql_query("select * from bsi_hotel_extras where `hotel_id`=".$hotelid);
		if(mysql_num_rows($sqlcategory)){			
			$getCategoryList = "";
			while($rowCategoryList=mysql_fetch_assoc($sqlcategory)){
				$getCategoryList .='<tr class="gradeX"><td>'.$rowCategoryList['service_name'].'</td><td>'.$bsiCore->currency_symbol().$rowCategoryList['service_price'].'</td><td  align="right" style="padding:0 15px; 0 0;"><a href="add_new_extras.php?eid='.base64_encode($rowCategoryList['id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:extras_delete('.$rowCategoryList['id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"categoryList"=>$getCategoryList));
		}else{
			$errorcode = 1; 
			$strmsg = "Sorry! no extras found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function getoffer(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);	
		$sqlcategory = mysql_query("select * ,date_format(start_dt,'".$bsiCore->userDateFormat."') as 	start_dt , date_format(end_dt,'".$bsiCore->userDateFormat."') as end_dt from `bsi_hotel_offer`  where `hotel_id`=".$hotelid);
		if(mysql_num_rows($sqlcategory)){			
			$getCategoryList = "";
			while($rowCategoryList=mysql_fetch_assoc($sqlcategory)){
				$getCategoryList .='<tr class="gradeX"><td>'.$rowCategoryList['offer_name'].'</td>
				<td>'.$rowCategoryList['start_dt'].'</td>
				<td>'.$rowCategoryList['end_dt'].'</td>
				<td>'.$rowCategoryList['minimum_nights'].'</td>
				<td>'.$rowCategoryList['discount_percent'].' %</td>
				<td  align="right" ><a href="add_new_offer.php?eid='.base64_encode($rowCategoryList['id']).'&addedit=1">Edit</a> | <a href="javascript:;" onclick="javascript:offer_delete('.$rowCategoryList['id'].');">Delete</a></td></tr>';		
			}
			echo json_encode(array("errorcode"=>$errorcode,"categoryList"=>$getCategoryList));
		}else{
			$errorcode = 1; 
			$strmsg = "Sorry! no extras found in this hotel!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));
		}
	}
	
	public function updatedispute(){
		
		global $bsiCore;
		//$bsiMail   = new bsiMail();
		$errorcode = 0;
		$strmsg    = "";
		$sucess    = '';
		$error     = 'Try After Some Time';
		$dispute  = $bsiCore->ClearInput($_POST['dispute']);
		$booking_id  = $bsiCore->ClearInput($_POST['booking_id']);	
		$search    = mysql_query("select `boking_status` from `bsi_reservation` where booking_id='".$booking_id."'");
				
		if(mysql_num_rows($search)){
			mysql_query("UPDATE `bsi_reservation` SET `booking_dispute` = '".$dispute."' WHERE `booking_id` ='".$booking_id."'");
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{			
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$error));	
		}
		
	}
	
}
?>