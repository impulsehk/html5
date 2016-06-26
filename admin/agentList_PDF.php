<?php
include ("access.php");  
//echo "in pdf";die;
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	require_once('../tcpdf_min/tcpdf.php');
	$sqlQuery = base64_decode($_GET['query']); 	  
	//echo $sqlQuery;die;
// extend TCPF with custom functions
class MYPDF extends TCPDF { 
	//customisied header
	
	public function Header() { 
        // Logo 
		$bsiCore = new bsiHotelCore;
		if($bsiCore->config['conf_pdf_logo'] != ""){
			$image_file = '../gallery/portal/'.$bsiCore->config['conf_pdf_logo'];
		}else{
			$image_file = '';
		}
        
        $this->Image($image_file, 15, 5, 60, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
		$head=$bsiCore->config['conf_portal_name'];
        $this->Cell(0, 0, $head, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }
	
    // Load table data from file
   	public function LoadData($data){
		$result        = mysql_query($data);
		$rowHotelList  = "";
		$rowHotelArray = array();
		while($rowAgent = mysql_fetch_assoc($result)){
		//echo "select * from bsi_country where country_code='".$rowAgent['country']."'";die;
			$rowcontry = mysql_fetch_assoc(mysql_query("select * from bsi_country where country_code='".$rowAgent['country']."'"));
		    $rowHotelList.=$rowAgent['agent_id'].";".$rowAgent['fname']." ".$rowAgent['lname'].";".$rowAgent['email'].";".$rowAgent['phone'].";".$rowAgent['address'].";".$rowAgent['city'].";".$rowAgent['state'].";".$rowcontry['name'].";";
		}
		//echo $rowHotelList;die;
		
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
        $this->SetLineWidth(0.1);
        $this->SetFont('', '');
        // Header
        $w = array(15, 40, 45, 25, 50, 20, 30, 35);
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
		$datacount=count($data);
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
        $this->Cell(array_sum($w), 0, '', '');
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
//$pdf->SetHeaderData('', '', 'Best Soft Inc', "2/69A Dum Dum Road\nKolkata - 700074\nWB, INDIA");

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
$header = array('Agent Id', 'Agent Name', 'Email', 'Phone', 'Address', 'City', 'State', 'Country');

//Data loading
$rowHotelArray = $pdf->LoadData($sqlQuery);

// print colored table
$pdf->ColoredTable($header, $rowHotelArray);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('HotelList.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
