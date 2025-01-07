<?php
session_start();
include_once 'includes/config.php';
require_once('TCPDF-main/tcpdf.php'); // Adjust the path if needed

// Get the order ID from the query parameter
$oid = intval($_GET['oid']);

// Fetch order tracking details from the database
$orderDetails = "";
$ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
if (mysqli_num_rows($ret) > 0) {
    while ($row = mysqli_fetch_assoc($ret)) {
        $orderDetails .= "Date: " . $row['postingDate'] . "\n";
        $orderDetails .= "Status: " . $row['status'] . "\n";
        $orderDetails .= "Remark: " . $row['remark'] . "\n";
        $orderDetails .= "-------------------------\n";
    }
} else {
    $orderDetails = "Order not processed yet.";
}

// Create a new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Twenty-One Chabzy Store');
$pdf->SetTitle('Order Tracking Details');
$pdf->SetHeaderData('', 0, "Twenty-One Chabzy Store", ''); // Only store name in the header

// Add a page
$pdf->AddPage();

// Set the content of the PDF
$pdfContent = "Order Tracking Details\n";
$pdfContent .= "Order ID: " . $oid . "\n";
$pdfContent .= "-------------------------\n";
$pdfContent .= $orderDetails;

// Output the content
$pdf->SetFont('helvetica', '', 12);
$pdf->MultiCell(0, 0, $pdfContent);

// Set headers for PDF download
$pdf->Output("order_$oid" . "_details.pdf", 'D');
exit;
?>

