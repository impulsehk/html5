<?php
include ("access.php");
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	require_once('../tcpdf_min/tcpdf.php');	
	//echo $sqlQuery;die;
	if(isset($_SESSION['shortby'])){
		$sqlQuery="SELECT booking_id, CONCAT(bsi_clients.first_name,' ',bsi_clients.surname) as Name, bsi_clients.phone, DATE_FORMAT(checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(checkout_date, '".$bsiCore->userDateFormat."') AS end_date, total_cost,  DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, gateway_name FROM bsi_bookings, bsi_clients, bsi_payment_gateway where bsi_clients.client_id = bsi_bookings.client_id and bsi_payment_gateway.gateway_code=bsi_bookings.payment_type and payment_success=true and (CURDATE() > checkout_date or is_deleted=true) and is_block=false and hotel_id=".$_SESSION['hotelidpdf']." and (DATE_FORMAT(".mysql_real_escape_string($_SESSION['shortby']).", '%Y-%m-%d') between '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_in']))."' and '".$bsiCore->getMySqlDate(mysql_real_escape_string($_SESSION['check_out']))."')"; 
	}else{
		$sqlQuery="select bb.booking_id, CONCAT(bc.first_name,' ',bc.surname) as Name, bc.phone, DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS start_date, DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS end_date, DATE_FORMAT(booking_time, '".$bsiCore->userDateFormat."') AS booking_time, bb.total_cost, bpg.gateway_name from bsi_bookings as bb, bsi_clients as bc, bsi_payment_gateway as bpg where bb.client_id=bc.client_id and bpg.gateway_code = bb.payment_type and bb.hotel_id = '".$bsiCore->ClearInput($_GET['hotelid'])."' and (checkout_date < curdate() or bb.is_deleted = '1')";
}
// extend TCPF with custom functions
class MYPDF extends TCPDF {
    // Load table data from file
   	public function LoadData($data){
		global $bsiCore;
		$sqlQuery     = mysql_query($data);
		$rowHotelList = "";
		$rowHotelArray=array();
		while($rowHotel=mysql_fetch_assoc($sqlQuery)){
			$rowHotelList.=$rowHotel['booking_id'].";".$rowHotel['Name'].";".$rowHotel['phone'].";".$rowHotel['booking_time'].";".$rowHotel['start_date'].";".$rowHotel['end_date'].";".$bsiCore->config['conf_currency_symbol'].$rowHotel['total_cost'].";".$rowHotel['gateway_name'].";";
		}
		$rowHotelList=substr($rowHotelList,0,-1);
		$rowHotelArray=explode(";",chop($rowHotelList));
		return $rowHotelArray;
	}
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(94, 188, 248);
        $this->SetTextColor(94);
        $this->SetDrawColor(94, 188, 248);
        $this->SetLineWidth(0.3);
        $this->SetFont('', '');
        // Header
        $w = array(40, 40, 20, 30, 30, 30, 24, 27);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;		
		$datacount = count($data);
		$c=1;
		for($i=0; $i<$datacount;++$i){
			$this->Cell($w[$c-1], 9, $data[$i], 'LR', 0, 'L', $fill,'', 1);
			if($c==8){
				$this->Ln();
				$c=0;
				$fill=!$fill;	
			}
			$c++;
		}
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
if(isset($_REQUEST['hotelid'])){
	$hotelRow = $bsiCore->getHotelDetails($_REQUEST['hotelid']);
	$pdf->SetHeaderData('', '', ucwords($hotelRow['hotel_name']), 'Booking History List');
}else{
	$hotelRow = $bsiCore->getHotelDetails($_SESSION['hotelidpdf']);
	$pdf->SetHeaderData('', '', ucwords($hotelRow['hotel_name']), 'Booking History List - ( '.$_SESSION['check_in'].' TO '.$_SESSION['check_out'].' BY '.ucwords(str_replace("_", " ", $_SESSION['shortby'])).' ) ');
}
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, 40);
$pdf->SetHeaderMargin(12);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings

// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', '', 9);
// add a page
$pdf->AddPage($orientation = 'L');
//Column titles
$header = array('Booking ID', 'Name', 'Phone','Booking Date','Checkin Date','Checkout Date','Amount','Payment Method');
//Data loading
$rowHotelArray = $pdf->LoadData($sqlQuery);
// print colored table
$pdf->ColoredTable($header, $rowHotelArray);
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('DateWiseBookingList.pdf', 'I');
//============================================================+
// END OF FILE                                                
//============================================================+