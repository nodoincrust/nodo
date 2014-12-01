<?php
include 'PdfaidServices.php';
 
$myDoc2Pdf = new Doc2PdfConverter();
$myDoc2Pdf->apiKey = "fzb2tptnbl20is";
$myDoc2Pdf->inputDocLocation = "DMSTree_clients/Midway_Software_Solution_Pvt._3/Documents/Comments_on_screens_20_08_2014_0.docx";
//please make sure that the dir is writable chmod 777
$myDoc2Pdf->outputPdfLocation = "DMSTree_clients/Midway_Software_Solution_Pvt._3/Documents/Comments_on_screens_20_08_2014_0.pdf";
$myDoc2Pdf->pdfAuthor ="My php Author";
$myDoc2Pdf->pdfTitle = "My php Title";
$myDoc2Pdf->pdfSubject = "my php subject";
$myDoc2Pdf->pdfKeywords ="my php keywords";
//$result will be OK or APINOK or Error Message 
$result = $myDoc2Pdf->Doc2PdfConvert();
?>