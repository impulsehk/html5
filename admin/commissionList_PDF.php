<?php
include ("access.php");   
	include("../includes/db.conn.php");  
	include("../includes/conf.class.php");
	require_once('../tcpdf_min/tcpdf.php');
	$comm = $bsiCore->ClearInput($_GET['comm']);
	$cur  = $bsiCore->config['conf_currency_symbol'];
	$sqlQuery = "select bb.booking_id, bh.hotel_name, bc.first_name, bc.surname, DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') as booking_time, DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date, DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date, bb.payment_amount, bpg.gateway_name, bb.commission from bsi_bookings bb, bsi_hotels bh, bsi_clients bc, bsi_payment_gateway bpg where bb.agent=true and bb.payment_success=true and bb.hotel_id=bh.hotel_id and bb.client_id=bc.client_id and bb.payment_type=bpg.gateway_code and bb.agent_id=$comm";	
	$arr = array($sqlQuery, $cur);
// extend TCPF with custom functions
class MYPDF extends TCPDF {
	//customisied header
	public function Header() { 
        // Logo
		$bsiCore = new bsiHotelCore;
		$image_file = '../gallery/portal/'.$bsiCore->config['conf_pdf_logo'];
        $this->Image($image_file, 15, 5, 60, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
		$head=$bsiCore->config['conf_portal_name'];
        $this->Cell(0, 0, $head, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }
    // Load table data from file
   	public function LoadData($data){
		$query = $data[0];
		$cur   = $data[1];
		$sqlQuery     = mysql_query($query);
		$rowHotelList = "";
		$rowHotelArray=array();
		while($rowHotel=mysql_fetch_assoc($sqlQuery)){
			$rowHotelList.=$rowHotel['booking_id'].";".$rowHotel['hotel_name'].";".$rowHotel['first_name']." ".$rowHotel['surname'].";".$rowHotel['checkin_date'].";".$rowHotel['checkout_date'].";".$cur.$rowHotel['payment_amount'].";".$rowHotel['booking_time'].";".$cur.$rowHotel['commission'].";";
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
        $w = array(20, 40, 40, 20, 20, 20, 40, 20);
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
			$this->Cell($w[$c-1], 8, $data[$i], 'LR', 0, 'L', $fill,'', 1);
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

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
$header = array('Booking Id', 'Hotel Name', 'Customer Name', 'Checkin Date', 'Checkout Date', 'Amount', 'Booking Date', 'Commission');

//Data loading
$rowHotelArray = $pdf->LoadData($arr);

// print colored table
$pdf->ColoredTable($header, $rowHotelArray);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('commissionList_PDF.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
