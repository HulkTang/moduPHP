<?php
require_once '../../include.php';
$cardNumber=isset($_REQUEST['cardNumber'])?(int)$_REQUEST['cardNumber']:null;
if($cardNumber==null)
    echo '请填写卡号';
else{
    $cardNumber = getCardNumberVerified($cardNumber);
    echo $cardNumber;
}

?>