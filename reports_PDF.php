<?php
// version: 	1.0
// Tipo: 		Perfectivo
// Descripcion:	Procedimiento de parametrizacion de archivo PDF. Libreria PHP "dompdf"
// Autor:		Cesar Cuenca
// Fecha:		07/NOV/12
// ________________________________________________________

//require_once("dompdf/dompdf_config.inc.php");
require_once('tcpdf/config/lang/spa.php');
require_once('tcpdf/tcpdf.php');

$html_PDF=utf8_encode($_POST['datos_a_enviar']);
$html_PDF=str_replace('\\','',$html_PDF);
$fecha=date('d-M-Y');
$file=$fecha.'_'.$_POST['titulo'].'.pdf';
$html_PDF=stripslashes($html_PDF);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);  
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gestor F1');
$pdf->SetTitle($file);
$pdf->SetSubject('Reporte PDF');
$pdf->SetKeywords('PDF, ordenes');

//$old_limit = ini_set("memory_limit", "128M");
//$dompdf = new DOMPDF();
//$dompdf->load_html($html_PDF);
//$dompdf->set_paper("letter", "landscape");
//$dompdf->render();
//$dompdf->stream($file);
//exit(0);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

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
$pdf->setLanguageArray($l);
// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);
// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// output the HTML content

$certificado = 'file://'.$_SERVER["DOCUMENT_ROOT"]."/gestor_demo/tcpdf/tcpdf.crt";
$clave_privada = 'file://'.$_SERVER["DOCUMENT_ROOT"]."/gestor_demo/tcpdf/tcpdf.crt";
$info = array('Name' => 'PDF','Location' => 'La Paz - BOLIVIA','Reason' => ' Gestor-F1',
    'ContactInfo' => 'http://www.yanapti.com');
$pdf->setSignature($certificado, $clave_privada, 'tcpdfdemo', '', 3, $info); 
$pdf->writeHTML($html_PDF, true, false, true, false, '');
$pdf->lastPage();

$numero_aleatorio=time()."-ZQT"; 
$pdf->Rect(53,133,65,62,'FD','',array(210,210,210)); 
$sello="Reporte PDF\n FIRMADO DIGITALMENTE\n ".'Documento autentico'."\n Fecha: ".date('d-m-Y')."\nHora: ".date('h:i:s'); 
$sello.="\n Pulsa para comprobar firma"; 
$pdf->Multicell (60, 0, utf8_encode($sello), 1, 'C', 1, 0, 55, 135, true, 0, false, true, 0, 'T',false);
$pdf->SetFont('helvetica', '', 8); 
$pdf->write1DBarcode($numero_aleatorio, 'C93', 55, 170, 60, 18, 0.4, array('border'=>true,'text'=>true,'stretchtext'=>0,'fitwidth'=>true), 'N'); 

$pdf->setSignatureAppearance($x=53, $y=133, $w=65, $h=62);
$pdf->SetXY(25,230);
$pdf->Cell(0, 0, "Puedes comprobar la autencidad de este documento en: http://localhost/gestor_demo/".$numero_aleatorio.".pdf",'','','','','http://loscalhost/gestor_demo/'.$numero_aleatorio.'.pdf');


$pdf->Output($numero_aleatorio.".pdf", 'I');
?>