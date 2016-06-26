<?php
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/admin.class.php");
include("includes/ajaxprocess.class.php");
include("includes/mail.class.php");
$AjaxProcessor=new AjaxProcessor();
$actionCode = isset($_POST['actioncode']) ? $_POST['actioncode'] : 0;
//echo $actionCode ;die;
switch($actionCode){
	case "1": $AjaxProcessor->saveSubmitReview(); break;
	case "2": $AjaxProcessor->getRoomCapacity(); break; 
	case "3": $AjaxProcessor->updateProfile(); break;
	case "4": $AjaxProcessor->getExchangemoney(); break;
	case "5": $AjaxProcessor->changePassword(); break;
	case "6": $AjaxProcessor->getContact(); break;
	case "7": $AjaxProcessor->insertNews(); break;
	case "8": $AjaxProcessor->getCCform(); break;
	case "9": $AjaxProcessor->agent_updateProfile(); break;
	case "10": $AjaxProcessor->agent_changePassword(); break;
	case "11": $AjaxProcessor->getHotelRoomCapacity(); break;	
	case "12": $AjaxProcessor->validateLogin(); break;	
	case "13": $AjaxProcessor->forgotPassword(); break;	
	case "14": $AjaxProcessor->validateagentLogin(); break;	
	case "15": $AjaxProcessor->generatecitydrop();break;	
	case "16": $AjaxProcessor->forgotagentPassword(); break;	
	case "17": $AjaxProcessor->testapplyCouponDiscount();break;	
	case "18": $AjaxProcessor->hoteldetailspricecalculate();break;
	case "19": $AjaxProcessor->autocompleteSearch();break;
	case "20": $AjaxProcessor->hotelpanelroomBlocking();break; 
	case "21": $AjaxProcessor->increaseRoomno();break; 
	case "22": $AjaxProcessor->hotelstatus();break;
	case "23": $AjaxProcessor->setroomprice();break;
	case "24": $AjaxProcessor->increaseRoom();break; 
	case "25": $AjaxProcessor->updatebookingstatus();break; 
	default:  $AjaxProcessor->sendErrorMsg();
}
?>