<?php
header('Content-type: text/html; charset=utf-8');
include_once('db/connect.php');
session_start();
//////helper momo 
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

if (isset($_SESSION['thanhtoan'])) {
    try {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $_SESSION['thanhtoan'];
        echo "tiền:";
        echo $amount;
        //$orderId = time() . "";
        // $redirectUrl = "http://localhost/code/";
        // $ipnUrl = "http://localhost/code/checkout.php";

        $redirectUrl = "http://localhost/code/checkout.php";
        $ipnUrl = "http://localhost/code/";
        $extraData = "";
        $requestId = time() . "";
        $requestType = "payWithATM";

        do {
            $orderId = time() . "";
            $query3 = "SELECT ID FROM su_dung_dich_vu WHERE ID ='$orderId' ";
            $result3 = mysqli_query($conn, $query3);
            if (mysqli_num_rows($result3) > 0) {
                $orderId = '';
            }
        } while (!$orderId);

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId .
            "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true); // decode json
        header('Location: ' . $jsonResult['payUrl']);
    } catch (Exception $e) {
        echo '<script type="text/javascript"> alert(\'Lỗi thanh toán vui lòng thử lại sau\'); </script>';
    }
}
?>