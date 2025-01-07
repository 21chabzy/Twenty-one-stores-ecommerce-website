<?php
if (isset($_GET['status'])) {
    //* Check payment status
    if ($_GET['status'] == 'cancelled') {
        echo "<script>alert('You canceled the payment process');</script>";
        echo "<script>window.location.href = '../my-cart.php';</script>";
    } elseif ($_GET['status'] == 'successful') {
        $txid = $_GET['transaction_id'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer "
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response);
        if ($res->status) {
            $amountPaid = $res->data->charged_amount;
            $amountToPay = $res->data->meta->price;
            if ($amountPaid >= $amountToPay) {
                // Update the order history after a successful payment
                session_start();
                include('../includes/config.php'); // Include your database configuration

                // Update orders with the payment method
                $userId = $_SESSION['id']; // Assumes the user ID is stored in session
                mysqli_query($con, "UPDATE orders SET paymentMethod='Flutterwave' WHERE userId='$userId' AND paymentMethod IS NULL");

                // Clear the cart session
                unset($_SESSION['cart']);

                // Redirect to order history
                echo "<script>
                        alert('Payment successful');
                        window.location.href = '../order-history.php';
                      </script>";
            } else {
                echo "<script>alert('Fraud transaction detected');</script>";
            }
        } else {
            echo "<script>alert('Cannot process payment');</script>";
        }
    }
}
?>
