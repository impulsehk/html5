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
    include("access.php");
    include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	require_once('../tcpdf_min/tcpdf.php');

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
        $w = array(35, 55, 25, 32,20,20,30,50);
        $num_headers = count($header);
		 for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
		$fill = 0;
		for($i=0;$i<count($data);$i++)
		{
			$value=explode(',',trim($data[$i]));
			//print_r($value);die;
			array_pop($value);
			
		for($j=0;$j<count($value);$j++)
		{
			if(isset($value[$j]))
			{
					if($j==1)
					{
					  $newval=explode(' ',$value[$j]);
					  $val1= $newval[0]."\n".$newval[1];
					 // echo $val1;die;
					 
					  $this->Cell($w[$j], 6, "$value[$j]", 'LR', 0, 'L', $fill);
					 // echo "</br>";
					 // $this->Cell($w[$j], 6, $newval[1], 'LR', 0, 'C', $fill);
					}else{
					   $this->Cell($w[$j], 6, $value[$j], 'LR', 0, 'L', $fill);
					}
		     }else{
				 break;
			 }
		}
		 $this->Ln();
		 $fill=!$fill;
		}
		
		/*echo "<pre>";
		print_r($filter);
		echo "</pre>";
		die();*/
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
$pdf->SetHeaderData('', '', 'Best Soft Inc', "2/69A Dum Dum Road\nKolkata - 700074\nWB, INDIA");

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
$header = array('Name', 'Street Address','City', 'Province', 'Zip','Country','Phone','Email');
$inputtext=$bsiCore->ClearInput($_GET['searchtext']);
// Sql Query................
	$viewcustomerres=mysql_query("SELECT CONCAT(bc.title,' ',bc.first_name,' ',bc.surname)as Name,CONCAT(bc.street_addr,' ',bc.street_addr2) as Streetaddr,bc.city,bc.province,bc.zip,bco.name,bc.phone,bc.email FROM bsi_clients as bc,bsi_country as bco WHERE bco.country_code=bc.country and CONCAT(title,first_name,surname) LIKE '%".$inputtext."%'") or die("Error at line : 11".mysql_error());
$data=array();
$n=0;	
while($rowviewcustomerres=mysql_fetch_row($viewcustomerres))
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
$pdf->Output('pdf/cust.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
