<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2010-08-08
//
// Description : Example 011 for TCPDF class
//               Colored Table
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */
	include ("access.php"); 
    include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	require_once('../tcpdf_min/tcpdf.php');
$hoteldetails=mysql_fetch_assoc(mysql_query("select bh.hotel_name,bh.address_1,bh.address_2,bh.city_name,bh.post_code,bc.cou_name from bsi_hotels as bh,bsi_country bc where bh.country_code=bc.country_code and hotel_id=".$bsiCore->ClearInput($_GET['hotelid'])));
$addr="".$hoteldetails['address_1']." ".$hoteldetails['address_2']."\n".$hoteldetails['city_name']." - ".$hoteldetails['post_code']."\n".$hoteldetails['cou_name']."";
// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Load table data from file
   /* public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }*/
 
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(94, 188, 248);
        $this->SetTextColor(94);
        $this->SetDrawColor(94, 188, 248);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(30, 30,42, 50,40,35,40);
        $num_headers = count($header);
		 for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
		$fill = 0;
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();*/
		for($i=0;$i<count($data);$i++)
		{
			$value=explode(',',trim($data[$i]));
			//print_r($value);die;
			array_pop($value);
			
		for($j=0;$j<count($value);$j++)
		{
			if(isset($value[$j]))
			{
				$this->Cell($w[$j], 8, $value[$j],'LR', 0, 'L', $fill,'', 1);	
			 }
		}
		$this->Ln();
		  $fill=!$fill;
		 
		}
		
		
        // Data
           
       
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

// set default header data
$pdf->SetHeaderData('','',$hoteldetails['hotel_name'],$addr);

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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage($orientation = 'L');

//Column titles
//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
//Column titles
$header = array('Booking ID', 'Name','Phone','Checkin Date','Checkout Date','Amount','Booking Time');
$hotelid=$bsiCore->ClearInput($_GET['hotelid']);
$booking_list_type=$bsiCore->ClearInput($_GET['booking_list_type']);
// Sql Query................
	$viewarchivbookresult=mysql_query("select bb.booking_id,CONCAT(bc.first_name,' ',bc.surname) as Name,bc.phone,DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date,DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date,bb.total_cost,DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time from bsi_bookings as bb,bsi_clients as bc where bb.client_id=bc.client_id and bb.hotel_id='".$hotelid."' and (checkout_date < curdate() OR bb.is_deleted='".$booking_list_type."')") or die("Error at line : 11".mysql_error());

$data=array();
$n=0;	
while($rowviewcustomerres=mysql_fetch_row($viewarchivbookresult))
{
	$strhtml='';
for($k=0;$k<count($rowviewcustomerres);$k++)
{	
$strhtml.=$rowviewcustomerres[$k].",";
}
$data[$n]=$strhtml;
$n++;
}
/*echo "<pre>";
print_r($data);
echo "</pre>";
die();*/
//Data loading
//$data = $pdf->LoadData('../cache/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('pdf/archive.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
