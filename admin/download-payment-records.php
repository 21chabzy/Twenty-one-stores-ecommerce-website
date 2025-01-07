<?php
session_start();
include('include/config.php');
require_once('../TCPDF-main/tcpdf.php');



if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Twenty-One Stores');
$pdf->SetTitle('Payment Records');
$pdf->SetHeaderData('', 0, 'Twenty-One Stores', 'Payment Records - ' . date('Y-m-d'));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default font and margins
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('dejavusans', '', 10);

// Add the title
$html = '<h1 style="text-align:center;">Twenty-One Stores</h1>';
$html .= '<h2 style="text-align:center;">Payment Records</h2>';
$html .= '<h4 style="text-align:center;">Date: ' . date('Y-m-d') . '</h4><br>';

// Table headers
$html .= '<table border="1" cellspacing="3" cellpadding="4">';
$html .= '<thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Product</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Grand Total</th>
            </tr>
          </thead>';
$html .= '<tbody>';

// Fetch payment records from the database
$query = "SELECT orders.id as oid, users.name as username, products.productName as productname, 
                 orders.paymentMethod as paymentmethod, orders.orderDate as paymentdate, 
                 (orders.quantity * products.productPrice + products.shippingCharge) as grandtotal 
          FROM orders 
          JOIN users ON orders.userId = users.id 
          JOIN products ON orders.productId = products.id";

$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $html .= '<tr>
                    <td>' . htmlentities($row['oid']) . '</td>
                    <td>' . htmlentities($row['username']) . '</td>
                    <td>' . htmlentities($row['productname']) . '</td>
                    <td>' . htmlentities($row['paymentmethod']) . '</td>
                    <td>' . htmlentities($row['paymentdate']) . '</td>
                    <td>' . htmlentities($row['grandtotal']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="6" style="text-align:center;">No records found.</td></tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output the PDF document
$pdf->Output('Payment_Records_' . date('Ymd') . '.pdf', 'D');
?>
