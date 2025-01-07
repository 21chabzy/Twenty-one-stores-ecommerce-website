<?php 
if(isset($_POST['pay']))
{
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    //* Prepare our wave request
    $request = [
        'tx_ref' => time(),
        'amount' => $amount,
        'currency' => 'ZMW',
        'payment_options' => 'mobilemoneyzambia',
        'redirect_url' => 'http://localhost/shopping/makepayments/process.php',
        'customer' => [
            'email' => $email,
            'name' => 'daniel'
        ],
        'meta' => [
            'price' => $amount
        ],
        'customizations' => [
            'title' => 'Paying for a sample product',
            'description' => 'sample'
        ]
    ];

    //flutterwave endpoint
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer FLWSECK_TEST-095d666fb2b0e3cf821999fbbb0a13e0-X',
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $res = json_decode($response);
    if($res->status == 'success')
    {
        $link = $res->data->link;
        header('Location: '.$link);
    }
    else
    {
        echo '<script>alert("We can not process your payment");</script>';
    }
}

?>