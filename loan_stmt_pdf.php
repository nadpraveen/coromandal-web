<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//include autoloader

require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();
$output = file_get_contents("http://coromandelcoopsociety.com/loan_certi.php?gl_no=2059&loan_no=21848");
//$output = "hello people";

//$page = file_get_contents("cat.html");
//$document->loadHtml($page);

$document->loadHtml($output);
//set page size and orientation
$document->setPaper('A4', '');

//Render the HTML as PDF

$document->render();

//Get output of generated pdf in Browser

$document->stream("Webslesson", array("Attachment" => 0));
//1  = Download
//0 = Preview
?>