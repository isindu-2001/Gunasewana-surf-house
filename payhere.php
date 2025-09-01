<?php
define('DB_SERVER', '142.91.102.107');
define('DB_USER', 'sysadmin_sliitppa');
define('DB_PASS', 'Sliitppa@2025');
define('DB_NAME', 'sysadmin_sliitppa');
date_default_timezone_set("Asia/Colombo");

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$merchant_id = "1220939";
$merchant_secret = "NDE1NjM5NDE4NTUwMDI2MDMyOTE4OTIxNzUwNTUxMjk2MzQ0NjIx";

$order_id = "ItemNo12345";
$amount = 1000;
$currency = "LKR";

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);

?><html>
<body>
<form method="post" action="https://sandbox.payhere.lk/pay/checkout">   
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">    <!-- Replace your Merchant ID -->
    <input type="hidden" name="return_url" value="http://sample.com/return">
    <input type="hidden" name="cancel_url" value="http://sample.com/cancel">
    <input type="hidden" name="notify_url" value="http://sample.com/notify">  
    </br></br>Item Details</br>
    <input type="text" name="order_id" value="<?php echo $order_id; ?>">
    <input type="text" name="items" value="Door bell wireless">
    <input type="text" name="currency" value="<?php echo $currency; ?>">
    <input type="text" name="amount" value="<?php echo $amount; ?>">  
    </br></br>Customer Details</br>
    <input type="text" name="first_name" value="Saman">
    <input type="text" name="last_name" value="Perera">
    <input type="text" name="email" value="samanp@gmail.com">
    <input type="text" name="phone" value="0771234567">
    <input type="text" name="address" value="No.1, Galle Road">
    <input type="text" name="city" value="Colombo">
    <input type="hidden" name="country" value="Sri Lanka">
    <input type="hidden" name="hash" value="<?php echo $hash; ?>">    <!-- Replace with generated hash -->
    <input type="submit" value="Buy Now">   
</form> 
</body>
</html>