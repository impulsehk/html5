<?php

session_start();

include("../includes/db.conn.php");

include("../includes/conf.class.php");

include("../includes/admin.ajaxprocess.class.php");	 

$adminAjaxProc = new adminAjaxProcessor();

$actionCode    = isset($_POST['actioncode']) ? $_POST['actioncode'] : 0;

switch($actionCode){

	case "1": $adminAjaxProc->getPricePlanFormGenerate(); break;

	case "2": $adminAjaxProc->getPricePlanForm(); break;

	case "3": $adminAjaxProc->getCategoryListGenerate(); break;

	case "4": $adminAjaxProc->getRoomListGenerate(); break;

	case "5": $adminAjaxProc->getPricePlanListGenerate(); break;

	case "6": $adminAjaxProc->getRooTypeListGenerate(); break;

	case "7": $adminAjaxProc->getRoomTypeandCapacityListGenerate(); break;

	case "8": $adminAjaxProc->getRoomTypeListGenerate(); break;

	case "9": $adminAjaxProc->getCapacityListGenerate(); break;

	case "10": $adminAjaxProc->getAroundListGenerate(); break;

	case "11": $adminAjaxProc->getCategoryAroundListGenerate(); break;

	case "12": $adminAjaxProc->getCategoryGenerate(); break;

	case "13": $adminAjaxProc->getHotelidtypephoto(); break; 

	case "14": $adminAjaxProc->getViewBooking(); break;

	case "15": $adminAjaxProc->getDiscounts(); break;

	case "16": $adminAjaxProc->getbsiEmailcontent(); break;

	case "17": $adminAjaxProc->getbsiClientinfo(); break;

	case "18": $adminAjaxProc->getbsiPromoCode(); break;

	case "19": $adminAjaxProc->getDiscountData(); break;

	case "20": $adminAjaxProc->searchResultByBookingId(); break;	

	case "21": $adminAjaxProc->getCustomerEmailcontent(); break;

	case "22": $adminAjaxProc->getHotelFacility(); break;  

	case "23": $adminAjaxProc->getRoomCapacity(); break;

	case "24": $adminAjaxProc->getCommissiontable(); break;  

	case "25": $adminAjaxProc->chekEmail();break; 

	case "26": $adminAjaxProc->getHotelidphoto();break;
	
	case "27": $adminAjaxProc->generatecitydrop();break;
	
	case "28": $adminAjaxProc->getdiscountupdate(); break;

	case "29": $adminAjaxProc->getdepositupdate(); break;
	
	case "30": $adminAjaxProc->getExtrabed(); break;
	
	case "31": $adminAjaxProc->getExtras(); break;
	
	case "32": $adminAjaxProc->getoffer(); break;
	
	case "33": $adminAjaxProc->updatedispute(); break;

	default:  $adminAjaxProc->sendErrorMsg();

}

?>